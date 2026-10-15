<?php

namespace Database\Seeders;

use App\Models\tracer\TracerSection;
use Illuminate\Database\Seeder;

class TracerSectionRuleSeeder extends Seeder
{
  public function run(): void
  {
    $rules = [

      // selalu tampil
      'BIODATA' => null,
      'STATUS' => null,
      'KOMPETENSI' => null,
      'PEMBELAJARAN' => null,
      'SARAN' => null,

      // tampil jika bekerja atau wirausaha
      'PEKERJAAN' => [
        'F8' => ['1', '3']
      ],

      // tampil jika wirausaha
      'WIRAUSAHA' => [
        'F8' => ['1', '3']
      ],


    ];

    foreach ($rules as $kode => $rule) {

      TracerSection::where('kode', $kode)
        ->update([
          'tampil_jika' => $rule
        ]);
    }
  }
}
