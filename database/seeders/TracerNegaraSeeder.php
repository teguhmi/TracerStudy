<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class TracerNegaraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
  public function run(): void
  {
    $rows = Excel::toArray([], database_path('data/tracer_negara.xlsx'));

    $data = [];

    foreach ($rows[0] as $index => $row) {

      if ($index === 0) {
        continue;
      }

      $data[] = [
        'kode'       => trim($row[0]),
        'nama'       => trim($row[1]),
        'created_at' => now(),
        'updated_at' => now(),
      ];
    }

    DB::table('tracer_negaras')->upsert(
      $data,
      ['kode'],
      ['nama', 'updated_at']
    );
  }
}
