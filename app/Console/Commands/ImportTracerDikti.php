<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ImportTracerDikti extends Command
{
  protected $signature = 'tracer:import-dikti {periode=1} {--kategori=}';

  protected $description = 'Import tracer_dikti_v1 ke tracer_respondens dan tracer_jawabans';

  public function handle()
  {
    ini_set('memory_limit', '-1');
    set_time_limit(0);
    DB::disableQueryLog();

    $periodeId  = (int) $this->argument('periode');
    $kategoriId = $this->option('kategori') !== null ? (int) $this->option('kategori') : null;
    $hasKategoriColumn = Schema::hasColumn('tracer_respondens', 'kategori_id');

    // Validasi periode_id sebelum proses berjalan
    $periodeExists = DB::table('tracer_periodes')->where('id', $periodeId)->exists();
    if (!$periodeExists) {
      $this->error("Periode ID {$periodeId} tidak ditemukan di tabel tracer_periodes.");
      return self::FAILURE;
    }

    $this->info('====================================');
    $this->info('IMPORT TRACER DIKTI DIMULAI');
    $this->info("Periode ID  : {$periodeId}");
    if ($kategoriId !== null) {
      $this->info("Kategori ID : {$kategoriId}");
    }
    $this->info('====================================');

    /*
    |--------------------------------------------------------------------------
    | STEP 1 : IMPORT RESPONDEN
    |--------------------------------------------------------------------------
    */
    $this->info('STEP 1 : Import Responden');

    $uniqueKeys = ['nim'];
    if ($hasKategoriColumn && $kategoriId !== null) {
      $uniqueKeys = ['kategori_id', 'nim'];
    }

    DB::table('tracer_dikti_v1')
      ->orderBy('id')
      ->chunkById(5000, function ($rows) use ($periodeId, $kategoriId, $hasKategoriColumn, $uniqueKeys) {

        $insert = [];

        foreach ($rows as $row) {

          $nim = preg_replace('/\s+/u', '', (string) ($row->nim ?? ''));

          // Skip NIM kosong atau terlalu panjang
          if ($nim === '' || strlen($nim) > 20) {
            continue;
          }

          $tanggalLulus = null;
          if (!empty($row->tahun_lulus) && is_numeric($row->tahun_lulus)) {
            $tanggalLulus = trim((string) $row->tahun_lulus) . '-12-31';
          }

          $noHp = trim((string) ($row->telepon ?? ''));
          if ($noHp === '' || strlen($noHp) > 30) {
            $noHp = null;
          }

          $record = [
            'periode_id'     => $periodeId,
            'nim'            => $nim,
            'nama'           => $row->nama_mahasiswa,
            'npwp'           => $row->npwp,
            'email'          => $row->email,
            'telepon'        => $noHp,
            'tanggal_lulus'  => $tanggalLulus,
            'status'         => 'submitted',
            'tanggal_mulai'  => now(),
            'tanggal_submit' => now(),
            'created_at'     => now(),
            'updated_at'     => now(),
          ];

          if ($hasKategoriColumn && $kategoriId !== null) {
            $record['kategori_id'] = $kategoriId;
          }

          // Gunakan $nim sebagai key agar tidak ada duplikat NIM dalam 1 batch upsert
          $insert[$nim] = $record;
        }

        if (!empty($insert)) {
          DB::table('tracer_respondens')->upsert(
            array_values($insert),
            $uniqueKeys,
            [
              'periode_id',
              'nama',
              'npwp',
              'email',
              'telepon',
              'tanggal_lulus',
              'updated_at',
            ]
          );
        }
      }, 'id');

    $this->info('Import Responden Selesai');

    /*
    |--------------------------------------------------------------------------
    | STEP 2 : MAP RESPONDEN & PERTANYAAN
    |--------------------------------------------------------------------------
    */
    $respondenQuery = DB::table('tracer_respondens')
      ->where('periode_id', $periodeId)
      ->orderBy('id');

    if ($hasKategoriColumn && $kategoriId !== null) {
      $respondenQuery->where('kategori_id', $kategoriId);
    }

    // Pastikan key map dinormalisasi sama persis seperti saat import
    $respondenMap = [];
    foreach ($respondenQuery->select('id', 'nim')->get() as $resp) {
      $cleanNim = preg_replace('/\s+/u', '', (string) $resp->nim);
      if ($cleanNim !== '') {
        $respondenMap[$cleanNim] = $resp->id;
      }
    }

    $pertanyaanMap = DB::table('tracer_pertanyaans')
      ->get()
      ->mapWithKeys(function ($item) {
        return [
          strtoupper(trim((string) $item->kode)) => $item->id
        ];
      })
      ->toArray();

    /*
    |--------------------------------------------------------------------------
    | AMBIL KOLOM F*
    |--------------------------------------------------------------------------
    */
    $kolomPertanyaan = collect(DB::select("
        SELECT COLUMN_NAME
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_SCHEMA = DATABASE()
        AND TABLE_NAME = 'tracer_dikti_v1'
        AND COLUMN_NAME REGEXP '^f'
        ORDER BY ORDINAL_POSITION
    "))
      ->pluck('COLUMN_NAME')
      ->toArray();

    $this->info('Total Responden Terpetakan : ' . count($respondenMap));
    $this->info('Total Kolom Pertanyaan     : ' . count($kolomPertanyaan));

    /*
    |--------------------------------------------------------------------------
    | STEP 3 : IMPORT JAWABAN
    |--------------------------------------------------------------------------
    */
    $totalData = DB::table('tracer_dikti_v1')->count();
    $bar = $this->output->createProgressBar($totalData);
    $bar->start();

    $totalJawaban = 0;

    DB::table('tracer_dikti_v1')
      ->orderBy('id')
      ->chunkById(1000, function ($rows) use (
        $kolomPertanyaan,
        $respondenMap,
        $pertanyaanMap,
        &$totalJawaban,
        $bar
      ) {

        $insert = [];

        foreach ($rows as $row) {

          $bar->advance();

          $nim = preg_replace('/\s+/u', '', (string) ($row->nim ?? ''));
          $respondenId = $respondenMap[$nim] ?? null;

          if (!$respondenId) {
            continue;
          }

          foreach ($kolomPertanyaan as $kolom) {

            $jawaban = $row->$kolom ?? null;
            if ($jawaban === null) {
              continue;
            }

            $jawaban = trim((string) $jawaban);
            if ($jawaban === '') {
              continue;
            }

            $kode = strtoupper($kolom);

            // Multi select
            if (in_array($kode, ['F4', 'F14', 'F15'], true)) {
              $jawaban = $this->convertMultiAnswer($kode, $jawaban);
            }

            $insert[] = [
              'responden_id'    => $respondenId,
              'pertanyaan_id'   => $pertanyaanMap[$kode] ?? null,
              'kode_pertanyaan' => $kode,
              'jawaban'         => $jawaban,
              'created_at'      => now(),
              'updated_at'      => now(),
            ];

            $totalJawaban++;

            if (count($insert) >= 5000) {
              DB::table('tracer_jawabans')->upsert(
                $insert,
                ['responden_id', 'kode_pertanyaan'],
                ['pertanyaan_id', 'jawaban', 'updated_at']
              );

              $insert = [];
            }
          }
        }

        if (!empty($insert)) {
          DB::table('tracer_jawabans')->upsert(
            $insert,
            ['responden_id', 'kode_pertanyaan'],
            ['pertanyaan_id', 'jawaban', 'updated_at']
          );
        }
      }, 'id');

    $bar->finish();
    $this->newLine(2);

    $this->info('====================================');
    $this->info('IMPORT SELESAI');
    $this->info('====================================');
    $this->info('Total Jawaban Diproses  : ' . $totalJawaban);
    $this->info('Total Jawaban Tersimpan : ' . DB::table('tracer_jawabans')->count());

    return self::SUCCESS;
  }

  /**
   * Convert multi answer
   * Contoh: 0103 => ["F401","F403"]
   */
  private function convertMultiAnswer(string $prefix, string $value): string
  {
    $items = [];

    foreach (str_split(trim($value), 2) as $kode) {
      $kode = trim($kode);

      if ($kode !== '' && $kode !== '00') {
        $items[] = $prefix . $kode;
      }
    }

    return json_encode(
      array_values(array_unique($items)),
      JSON_UNESCAPED_UNICODE
    );
  }
}
