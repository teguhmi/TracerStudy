<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class TracerProvinsiSeeder extends Seeder
{
  public function run(): void
  {
    $rows = Excel::toArray([], database_path('data/tracer_provinsi.xlsx'));

    $data = [];

    foreach ($rows[0] as $index => $row) {

      if ($index === 0) {
        continue;
      }

      $data[] = [
        'negara_id'  => $row[0],
        'kode'       => trim($row[1]),
        'nama'       => trim($row[2]),
        'created_at' => now(),
        'updated_at' => now(),
      ];
    }

    DB::table('tracer_provinsis')->upsert(
      $data,
      ['kode'],
      ['negara_id', 'nama', 'updated_at']
    );
  }
}
