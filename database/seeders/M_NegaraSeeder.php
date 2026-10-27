<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class M_NegaraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
  public function run(): void
  {
    $rows = Excel::toArray((object)[], database_path('data/m_negara.xlsx'));

    $data = [];

    foreach ($rows[0] as $index => $row) {

      if ($index === 0) {
        continue;
      }

      $data[] = [
        'kode_negara'       => trim($row[0]),
        'nama_negara'       => trim($row[1]),
        'status_aktif'      => trim($row[2]),
        'created_at' => now(),
        'updated_at' => now(),
      ];
    }

    DB::table('m_negaras')->upsert(
      $data,
      ['kode_negara'],
      ['nama_negara', 'updated_at']
    );
  }
}
