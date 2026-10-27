<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class M_ProvinsiSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $rows = Excel::toArray(
      (object)[],
      database_path('data/m_provinsi.xlsx')
    );

    $data = [];

    foreach ($rows[0] as $index => $row) {

      if ($index === 0) {
        continue; // Skip header
      }

      $data[] = [
        'id' => trim($row[0]),
        'negara_id' => trim($row[1]),
        'kode_provinsi' => trim($row[2]),
        'nama_provinsi' => trim($row[3]),
        'status_aktif' => trim($row[4]) ?: 1,
        'created_at' => now(),
        'updated_at' => now(),
      ];
    }

    DB::table('m_provinsis')->upsert(
      $data,
      ['id'],
      [
        'negara_id',
        'kode_provinsi',
        'nama_provinsi',
        'status_aktif',
        'updated_at',
      ]
    );
  }
}
