<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class M_KabupatenSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $rows = Excel::toArray(
      [],
      database_path('data/m_kabupaten_kota.xlsx')
    );

    $data = [];

    foreach ($rows[0] as $index => $row) {

      if ($index === 0) {
        continue; // Skip header
      }

      $data[] = [
        'id'                  => (int) $row[0],
        'provinsi_id'         => (int) $row[1],
        'kode_kabupaten_kota' => trim($row[2]),
        'nama_kabupaten_kota' => trim($row[3]),
        'status_aktif'        => !empty($row[4]) ? (int) $row[4] : 1,
        'created_at'          => now(),
        'updated_at'          => now(),
      ];
    }

    DB::table('m_kabupaten_kotas')->upsert(
      $data,
      ['id'],
      [
        'provinsi_id',
        'kode_kabupaten_kota',
        'nama_kabupaten_kota',
        'status_aktif',
        'updated_at',
      ]
    );
  }
}
