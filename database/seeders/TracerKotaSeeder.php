<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class TracerKotaSeeder extends Seeder
{
  public function run(): void
  {
    $rows = Excel::toArray(
      [],
      database_path('data/tracer_kota.xlsx')
    );

    $data = [];

    foreach ($rows[0] as $index => $row) {

      if ($index === 0) {
        continue; // skip header
      }

      $data[] = [
        'negara_id'  => trim($row[0]),
        'provinsi_id'=> trim($row[1]),
        'kode'       => trim($row[2]),
        'nama'       => trim($row[3]),
        'created_at' => now(),
        'updated_at' => now(),
      ];
    }

    DB::table('tracer_kotas')->upsert(
      $data,
      ['kode'],
      [
        'negara_id',
        'provinsi_id',
        'nama',
        'updated_at'
      ]
    );
  }
}
