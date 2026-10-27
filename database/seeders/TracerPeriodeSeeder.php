<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TracerPeriodeSeeder extends Seeder
{
  public function run(): void
  {
    DB::table('tracer_periodes')->updateOrInsert(
      ['id' => 1],
      [
        'nama_periode'  => '2026',
        'tahun_mulai'   => 2026,
        'tahun_selesai' => 2026,
        'aktif'         => 1,
        'created_at'    => now(),
        'updated_at'    => now(),
      ]
    );
  }
}
