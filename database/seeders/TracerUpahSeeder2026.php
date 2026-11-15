<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TracerUpahSeeder2026 extends Seeder
{
  public function run(): void
  {
    $now = now();

    $rows = [
      ['010000', 'DKI Jakarta',              2026, 5729876.00],
      ['020000', 'Jawa Barat',               2026, 2317601.00],
      ['030000', 'Jawa Tengah',              2026, 2327386.07],
      ['040000', 'DI. Yogyakarta',           2026, 2417495.00],
      ['050000', 'Jawa Timur',               2026, 2446880.00],
      ['060000', 'Aceh',                     2026, 3932552.00],
      ['070000', 'Sumatera Utara',           2026, 3228949.00],
      ['080000', 'Sumatera Barat',           2026, 3182955.00],
      ['090000', 'Riau',                     2026, 3780495.00],
      ['100000', 'Jambi',                    2026, 3471497.00],
      ['110000', 'Sumatera Selatan',         2026, 3942963.00],
      ['120000', 'Lampung',                  2026, 3047734.00],
      ['130000', 'Kalimantan Barat',         2026, 3054552.00],
      ['140000', 'Kalimantan Tengah',        2026, 3686138.00],
      ['150000', 'Kalimantan Selatan',       2026, 3725000.00],
      ['160000', 'Kalimantan Timur',         2026, 3762431.00],
      ['170000', 'Sulawesi Utara',           2026, 4002630.00],
      ['180000', 'Sulawesi Tengah',          2026, 3179565.00],
      ['190000', 'Sulawesi Selatan',         2026, 3921088.00],
      ['200000', 'Sulawesi Tenggara',        2026, 3306496.18],
      ['210000', 'Maluku',                   2026, 3334490.00],
      ['220000', 'Bali',                     2026, 3207459.00],
      ['230000', 'Nusa Tenggara Barat',      2026, 2673861.00],
      ['240000', 'Nusa Tenggara Timur',      2026, 2455898.00],
      ['250000', 'Papua',                    2026, 4436283.00],
      ['260000', 'Bengkulu',                 2026, 2827250.00],
      ['270000', 'Maluku Utara',             2026, 3510240.00],
      ['280000', 'Banten',                   2026, 3100881.40],
      ['290000', 'Bangka Belitung',          2026, 4035000.00],
      ['300000', 'Gorontalo',                2026, 3405144.00],
      ['310000', 'Kepulauan Riau',           2026, 3879520.00],
      ['320000', 'Papua Barat',              2026, 3841000.00],
      ['330000', 'Sulawesi Barat',           2026, 3315934.00],
      ['340000', 'Kalimantan Utara',         2026, 3775243.00],
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
