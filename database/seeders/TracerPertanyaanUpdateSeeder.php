<?php

namespace Database\Seeders;

use App\Models\tracer\TracerPertanyaan;
use Illuminate\Database\Seeder;

class TracerPertanyaanUpdateSeeder extends Seeder
{
  public function run(): void
  {
    $updates = [

      // ============================
      // STATUS PEKERJAAN
      // ============================

      'F18' => [
        'tampil_jika' => [
          'F8' => ['4']
        ]
      ],

      'F502' => [
        'tampil_jika' => [
          'F8' => ['1','3']
        ]
      ],

      'F505' => [
        'tampil_jika' => [
          'F8' => ['1','3']
        ]
      ],

      'F510' => [
        'tampil_jika' => [
          'F8' => ['1','3']
        ]
      ],

      'F5A1' => [
        'tampil_jika' => [
          'F8' => ['1','3'],
          'F5A0' => ['ID']
        ]
      ],

      'F5A2' => [
        'tampil_jika' => [
          'F8' => ['1','3'],
          'F5A0' => ['ID']
        ]
      ],

      'F1101' => [
        'tampil_jika' => [
          'F8' => ['1']
        ]
      ],

      'F1102' => [
        'tampil_jika' => [
          'F1101' => ['5']
        ]
      ],

      'F5B' => [
        'tampil_jika' => [
          'F8' => ['1']
        ]
      ],

      'F5D' => [
        'tampil_jika' => [
          'F8' => ['1','3']
        ]
      ],

      'F14' => [
        'tampil_jika' => [
          'F8' => ['1','3']
        ]
      ],

      'F15' => [
        'tampil_jika' => [
          'F8' => ['1','3']
        ]
      ],

      // ============================
      // PEMBIAYAAN
      // ============================

      'F1202' => [
        'tampil_jika' => [
          'F1201' => ['7']
        ]
      ],

      // ============================
      // PENCARI KERJA
      // ============================

      'F301' => [
        'tampil_jika' => [
          'F8' => ['1','2','3','5']
        ]
      ],

      'F302' => [
        'tampil_jika' => [
          'F301' => ['1']
        ]
      ],

      'F303' => [
        'tampil_jika' => [
          'F301' => ['2']
        ]
      ],

      'F4' => [
        'tampil_jika' => [
          'F8' => ['1','2','3','5']
        ]
      ],

      'F416' => [
        'tampil_jika' => [
          'F4' => ['F415']
        ]
      ],

      'F6' => [
        'tampil_jika' => [
          'F8' => ['1','2','3','5']
        ]
      ],

      'F7' => [
        'tampil_jika' => [
          'F8' => ['1','2','3','5']
        ]
      ],

      'F7A' => [
        'tampil_jika' => [
          'F8' => ['1','2','3','5']
        ]
      ],

      'F1002' => [
        'tampil_jika' => [
          'F1001' => ['5']
        ]
      ],

      // ============================
      // KETIDAKSESUAIAN PEKERJAAN
      // ============================

      'F1614' => [
        'tampil_jika' => [
          'F1613' => ['1']
        ]
      ],
    ];

    foreach ($updates as $kode => $data) {

      TracerPertanyaan::where('kode', $kode)
        ->update($data);
    }
  }
}
