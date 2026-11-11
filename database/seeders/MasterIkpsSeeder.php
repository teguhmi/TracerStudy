<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterIkpsSeeder extends Seeder
{
  public function run(): void
  {
    DB::table('master_ikps')->insert([
      [
        'kode' => 'ikps30142',
        'nama' => 'IKPS 30.1.4.2',
        'created_at' => now(),
        'updated_at' => now(),
      ],
      [
        'kode' => 'ikps32131',
        'nama' => 'IKPS 32.1.3.1',
        'created_at' => now(),
        'updated_at' => now(),
      ],
      [
        'kode' => 'ikps35211',
        'nama' => 'IKPS 35.2.1.1',
        'created_at' => now(),
        'updated_at' => now(),
      ],
      [
        'kode' => 'ikps35212',
        'nama' => 'IKPS 35.2.1.2',
        'created_at' => now(),
        'updated_at' => now(),
      ],
    ]);
  }
}
