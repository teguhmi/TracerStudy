<?php

namespace Database\Seeders;

use App\Models\tracer\TracerSection;
use Illuminate\Database\Seeder;

class TracerSectionRuleSeeder extends Seeder
{
  public function run(): void
  {
    $rules = [

      'BIODATA' => null,
      'STATUS' => null,

      'PEKERJAAN' => [
        'F8' => ['1', '3']
      ],

      'WIRAUSAHA' => [
        'F8' => ['3']
      ],

      'STUDILANJUT' => [
        'F8' => ['4']
      ],

      'PENCARIKERJA' => [
        'F8' => ['1', '2', '3', '5']
      ],

      'KOMPETENSI' => null,
      'PEMBELAJARAN' => null,
      'SARAN' => null,
    ];

    foreach ($rules as $kode => $rule) {

      TracerSection::where('kode', $kode)
        ->update([
          'tampil_jika' => $rule
        ]);
    }
  }
}
