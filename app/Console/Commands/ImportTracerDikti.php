<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportTracerDikti extends Command
{
  protected $signature = 'tracer:import-dikti {periode=1}';

  protected $description = 'Import tracer_dikti_v1 ke tracer_respondens dan tracer_jawabans_test';

  public function handle()
  {
    ini_set('memory_limit', '-1');
    set_time_limit(0);

    $periodeId = $this->argument('periode');

    $this->info('====================================');
    $this->info('IMPORT TRACER DIKTI DIMULAI');
    $this->info('====================================');

    /*
    |--------------------------------------------------------------------------
    | STEP 1
    | IMPORT RESPONDEN
    |--------------------------------------------------------------------------
    */

    $this->info('STEP 1 : Import Responden');

    DB::table('tracer_dikti_v1')
      ->orderBy('ID')
      ->chunkById(5000, function ($rows) use ($periodeId) {

        $insert = [];

        foreach ($rows as $row) {

          $nim = trim((string) $row->nim);

          // skip nim kosong atau terlalu panjang
          if (
            empty($nim) ||
            strlen($nim) > 20
          ) {
            continue;
          }

          $tanggalLulus = null;

          if (
            !empty($row->tahun_lulus) &&
            is_numeric($row->tahun_lulus)
          ) {
            $tanggalLulus = $row->tahun_lulus . '-12-31';
          }

          $noHp = trim((string) $row->telepon);

          if (strlen($noHp) > 30) {
            $noHp = null;
          }

          $insert[] = [
            'periode_id'     => $periodeId,
            'nim'            => $nim,
            'nama'           => $row->nama_mahasiswa,
            'npwp'           => $row->npwp,
            'email'          => $row->email,
            'no_hp'          => $noHp,
            'tanggal_lulus'  => $tanggalLulus,
            'status'         => 'submitted',
            'tanggal_mulai'  => now(),
            'tanggal_submit' => now(),
            'created_at'     => now(),
            'updated_at'     => now(),
          ];
        }

        if (!empty($insert)) {

          DB::table('tracer_respondens')->upsert(
            $insert,
            ['nim'],
            [
              'nama',
              'npwp',
              'email',
              'no_hp',
              'tanggal_lulus',
              'updated_at',
            ]
          );
        }
      }, 'ID');

    $this->info('Import Responden Selesai');

    /*
    |--------------------------------------------------------------------------
    | MAP RESPONDEN
    |--------------------------------------------------------------------------
    */

    $respondenMap = DB::table('tracer_respondens')
      ->pluck('id', 'nim')
      ->toArray();

    /*
    |--------------------------------------------------------------------------
    | MAP PERTANYAAN
    |--------------------------------------------------------------------------
    */

    $pertanyaanMap = DB::table('tracer_pertanyaans')
      ->get()
      ->mapWithKeys(function ($item) {
        return [
          strtoupper($item->kode) => $item->id
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

    $this->info('Total Kolom Pertanyaan : '.count($kolomPertanyaan));

    /*
    |--------------------------------------------------------------------------
    | IMPORT JAWABAN
    |--------------------------------------------------------------------------
    */

    $totalData = DB::table('tracer_dikti_v1')->count();

    $bar = $this->output->createProgressBar($totalData);

    $bar->start();

    $totalJawaban = 0;

    DB::table('tracer_dikti_v1')
      ->orderBy('ID')
      ->chunkById(1000, function (
        $rows
      ) use (
        $kolomPertanyaan,
        $respondenMap,
        $pertanyaanMap,
        &$totalJawaban,
        $bar
      ) {

        $insert = [];

        foreach ($rows as $row) {

          $bar->advance();

          $nim = trim((string) $row->nim);

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

            /*
            |--------------------------------------------------------------------------
            | MULTI SELECT
            |--------------------------------------------------------------------------
            */

            if ($kode === 'F4') {
              $jawaban = $this->convertMultiAnswer('F4', $jawaban);
            }

            if ($kode === 'F14') {
              $jawaban = $this->convertMultiAnswer('F14', $jawaban);
            }

            if ($kode === 'F15') {
              $jawaban = $this->convertMultiAnswer('F15', $jawaban);
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

              DB::table('tracer_jawabans_test')->upsert(
                $insert,
                [
                  'responden_id',
                  'kode_pertanyaan'
                ],
                [
                  'pertanyaan_id',
                  'jawaban',
                  'updated_at'
                ]
              );

              $insert = [];
            }
          }
        }

        if (!empty($insert)) {

          DB::table('tracer_jawabans_test')->upsert(
            $insert,
            [
              'responden_id',
              'kode_pertanyaan'
            ],
            [
              'pertanyaan_id',
              'jawaban',
              'updated_at'
            ]
          );
        }
      }, 'ID');

    $bar->finish();

    $this->newLine(2);

    $this->info('====================================');
    $this->info('IMPORT SELESAI');
    $this->info('====================================');
    $this->info('Total Jawaban Diproses : '.$totalJawaban);
    $this->info(
      'Total Jawaban Tersimpan : ' .
      DB::table('tracer_jawabans_test')->count()
    );

    return self::SUCCESS;
  }

  /**
   * Convert multi answer
   * Contoh:
   * 0103 => ["F401","F403"]
   */
  private function convertMultiAnswer(
    string $prefix,
    string $value
  ): string {

    $items = [];

    foreach (str_split(trim($value), 2) as $kode) {

      $kode = trim($kode);

      if (
        $kode !== '' &&
        $kode !== '00'
      ) {
        $items[] = $prefix . $kode;
      }
    }

    return json_encode(
      array_values(array_unique($items)),
      JSON_UNESCAPED_UNICODE
    );
  }
}
