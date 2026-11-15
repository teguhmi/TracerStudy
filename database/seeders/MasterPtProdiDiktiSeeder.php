<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Facades\Excel;
use RuntimeException;

class MasterPtProdiDiktiSeeder extends Seeder implements ToCollection, WithHeadingRow, WithMultipleSheets
{
  public function run(): void
  {
    ini_set('memory_limit', '512M');
    DB::connection()->disableQueryLog();

    $paths = [
      database_path('data/PT_Prodi_Dikti-2026-10-23.xlsx'),
    ];

    $filePath = collect($paths)->first(fn ($path) => file_exists($path));

    if (! $filePath) {
      throw new RuntimeException("File XLSX tidak ditemukan di: {$paths[0]}");
    }

    Excel::import($this, $filePath);
  }

  /**
   * Hanya baca sheet pertama ("Data PT-Prodi") dan abaikan sheet "Ringkasan".
   */
  public function sheets(): array
  {
    return [
      0 => $this,
    ];
  }

  public function collection(Collection $rows): void
  {
    $now = now();
    $jenjangMap = [];
    $ptMap = [];
    $rawProdi = [];

    // 1. Ekstrak seluruh data master dalam sekali baca (1 pass)
    foreach ($rows as $row) {
      $id = trim((string) ($row['id'] ?? ''));
      if ($id === '' || ! is_numeric($id)) {
        continue;
      }

      $kodePt      = trim((string) ($row['kode_perguruan_tinggi'] ?? ''));
      $namaPt      = trim((string) ($row['nama_perguruan_tinggi'] ?? ''));
      $kodeProdi   = preg_replace('/[^0-9A-Za-z]/', '', (string) ($row['kode_program_studi'] ?? ''));
      $namaProdi   = trim((string) ($row['nama_program_studi'] ?? ''));
      $status      = isset($row['status']) && trim((string) $row['status']) !== ''
        ? trim((string) $row['status'])
        : null;
      $idJenjang   = isset($row['id_jenjang_pendidikan']) && trim((string) $row['id_jenjang_pendidikan']) !== ''
        ? (int) trim((string) $row['id_jenjang_pendidikan'])
        : null;
      $namaJenjang = isset($row['nama_jenjang_pendidikan']) && trim((string) $row['nama_jenjang_pendidikan']) !== ''
        ? trim((string) $row['nama_jenjang_pendidikan'])
        : null;

      if ($idJenjang !== null && $namaJenjang !== null) {
        $jenjangMap[$idJenjang] = [
          'id'         => $idJenjang,
          'nama'       => $namaJenjang,
          'created_at' => $now,
          'updated_at' => $now,
        ];
      }

      // Gunakan prefix 'pt_' agar PHP tidak mengubah kode PT numerik menjadi integer key
      if ($kodePt !== '') {
        $ptMap['pt_' . $kodePt] = [
          'kode'       => $kodePt,
          'nama'       => $namaPt,
          'created_at' => $now,
          'updated_at' => $now,
        ];
      }

      $rawProdi[] = [
        'id'                    => (int) $id,
        'kode_pt'               => $kodePt,
        'jenjang_pendidikan_id' => $idJenjang,
        'kode'                  => $kodeProdi,
        'nama'                  => $namaProdi,
        'status'                => $status,
      ];
    }

    // 2. Simpan Master Jenjang Pendidikan (12 data)
    if (! empty($jenjangMap)) {
      DB::table('master_jenjang_pendidikans')->upsert(
        array_values($jenjangMap),
        ['id'],
        ['nama', 'updated_at']
      );
    }

    // 3. Simpan Seluruh Master Perguruan Tinggi per 1.000 baris (6.554 data)
    foreach (array_chunk(array_values($ptMap), 1000) as $chunk) {
      DB::table('master_perguruan_tinggis')->upsert(
        $chunk,
        ['kode'],
        ['nama', 'updated_at']
      );
    }

    // 4. Ambil seluruh mapping [kode => id] dari database dengan key string eksplisit
    $ptIdByKode = [];
    DB::table('master_perguruan_tinggis')
      ->select('id', 'kode')
      ->orderBy('id')
      ->each(function ($pt) use (&$ptIdByKode) {
        $ptIdByKode['pt_' . trim((string) $pt->kode)] = (int) $pt->id;
      });

    // 5. Susun & Simpan Seluruh Master Program Studi per 1.000 baris (47.237 data)
    $prodiBatch = [];
    foreach ($rawProdi as $item) {
      $perguruanTinggiId = $ptIdByKode['pt_' . $item['kode_pt']] ?? null;

      if ($perguruanTinggiId === null) {
        continue;
      }

      $prodiBatch[] = [
        'id'                    => $item['id'],
        'perguruan_tinggi_id'   => $perguruanTinggiId,
        'jenjang_pendidikan_id' => $item['jenjang_pendidikan_id'],
        'kode'                  => $item['kode'],
        'nama'                  => $item['nama'],
        'status'                => $item['status'],
        'created_at'            => $now,
        'updated_at'            => $now,
      ];

      if (count($prodiBatch) === 1000) {
        DB::table('master_program_studis')->upsert(
          $prodiBatch,
          ['id'],
          ['perguruan_tinggi_id', 'jenjang_pendidikan_id', 'kode', 'nama', 'status', 'updated_at']
        );
        $prodiBatch = [];
      }
    }

    if (! empty($prodiBatch)) {
      DB::table('master_program_studis')->upsert(
        $prodiBatch,
        ['id'],
        ['perguruan_tinggi_id', 'jenjang_pendidikan_id', 'kode', 'nama', 'status', 'updated_at']
      );
    }

    $this->command?->info(sprintf(
      'Selesai: %d Jenjang, %d Perguruan Tinggi, %d Program Studi.',
      DB::table('master_jenjang_pendidikans')->count(),
      DB::table('master_perguruan_tinggis')->count(),
      DB::table('master_program_studis')->count()
    ));
  }
}
