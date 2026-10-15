<?php

namespace Database\Seeders;

use App\Models\tracer\TracerSection;
use Illuminate\Database\Seeder;

class TracerSectionSeeder extends Seeder
{
  public function run(): void
  {
    $sections = [
      [
        'kode' => 'BIODATA',
        'nama' => 'Data Alumni',
        'urutan' => 1,
      ],
      [
        'kode' => 'STATUS',
        'nama' => 'Status Alumni',
        'urutan' => 2,
      ],
      [
        'kode' => 'PEKERJAAN',
        'nama' => 'Pekerjaan',
        'urutan' => 3,
      ],
      [
        'kode' => 'WIRAUSAHA',
        'nama' => 'Wirausaha',
        'urutan' => 4,
      ],
      [
        'kode' => 'STUDILANJUT',
        'nama' => 'Studi Lanjut',
        'urutan' => 5,
      ],
      [
        'kode' => 'PENCARIKERJA',
        'nama' => 'Pencarian Kerja',
        'urutan' => 6,
      ],
      [
        'kode' => 'KOMPETENSI',
        'nama' => 'Kompetensi Alumni',
        'urutan' => 7,
      ],
      [
        'kode' => 'PEMBELAJARAN',
        'nama' => 'Metode Pembelajaran',
        'urutan' => 8,
      ],
      [
        'kode' => 'SARAN',
        'nama' => 'Saran dan Masukan',
        'urutan' => 9,
      ],
    ];

    foreach ($sections as $section) {

      \App\Models\tracer\TracerSection::updateOrCreate(
        [
          'kode' => $section['kode']
        ],
        $section
      );
    }
  }
}
