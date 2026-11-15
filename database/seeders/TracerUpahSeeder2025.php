<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TracerUpahSeeder2025 extends Seeder
{
  public function run(): void
  {
    $now = now();

    $rows = [
      ['010000', 'Prov. D.K.I. Jakarta',      2025, 5396761.00],
      ['020000', 'Prov. Jawa Barat',          2025, 2191232.18],
      ['030000', 'Prov. Jawa Tengah',         2025, 2169349.00],
      ['040000', 'Prov. D.I. Yogyakarta',     2025, 2264080.95],
      ['050000', 'Prov. Jawa Timur',          2025, 2305985.00],
      ['060000', 'Prov. Aceh',                2025, 3685616.00],
      ['070000', 'Prov. Sumatera Utara',      2025, 2992559.00],
      ['080000', 'Prov. Sumatera Barat',      2025, 2994193.47],
      ['090000', 'Prov. Riau',                2025, 3508776.22],
      ['100000', 'Prov. Jambi',               2025, 3234535.00],
      ['110000', 'Prov. Sumatera Selatan',    2025, 3681571.00],
      ['120000', 'Prov. Lampung',             2025, 2893070.00],
      ['130000', 'Prov. Kalimantan Barat',    2025, 2878286.00],
      ['140000', 'Prov. Kalimantan Tengah',   2025, 3473621.04],
      ['150000', 'Prov. Kalimantan Selatan',  2025, 3496195.00],
      ['160000', 'Prov. Kalimantan Timur',    2025, 3579313.77],
      ['170000', 'Prov. Sulawesi Utara',      2025, 3775425.00],
      ['180000', 'Prov. Sulawesi Tengah',     2025, 2915000.00],
      ['190000', 'Prov. Sulawesi Selatan',    2025, 3657527.37],
      ['200000', 'Prov. Sulawesi Tenggara',   2025, 3073551.70],
      ['210000', 'Prov. Maluku',              2025, 3141700.00],
      ['220000', 'Prov. Bali',                2025, 2996561.00],
      ['230000', 'Prov. Nusa Tenggara Barat', 2025, 2602931.00],
      ['240000', 'Prov. Nusa Tenggara Timur', 2025, 2328969.69],
      ['250000', 'Prov. Papua',               2025, 4285850.00],
      ['260000', 'Prov. Bengkulu',            2025, 2670039.39],
      ['270000', 'Prov. Maluku Utara',        2025, 3408000.00],
      ['280000', 'Prov. Banten',              2025, 2905119.90],
      ['290000', 'Prov. Bangka Belitung',     2025, 3876600.00],
      ['300000', 'Prov. Gorontalo',           2025, 3221731.00],
      ['310000', 'Prov. Kepulauan Riau',      2025, 3623654.00],
      ['320000', 'Prov. Papua Barat',         2025, 3615000.00],
      ['330000', 'Prov. Sulawesi Barat',      2025, 3104430.00],
      ['340000', 'Prov. Kalimantan Utara',    2025, 3580160.00],
    ];

    $data = array_map(fn ($row) => [
      'kode'       => $row[0],
      'nama'       => $row[1],
      'tahun'      => $row[2],
      'upah'       => $row[3],
      'created_at' => $now,
      'updated_at' => $now,
    ], $rows);

    DB::table('tracer_upah')->upsert(
      $data,
      ['kode', 'tahun'],
      ['nama', 'upah', 'updated_at']
    );
  }
}
