<?php

namespace Database\Seeders;

use App\Models\tracer\TracerPertanyaan;
use Illuminate\Database\Seeder;

class TracerPertanyaanSeeder extends Seeder
{
  public function run(): void
  {


    $pertanyaans = [

      // =====================
      // STATUS
      // =====================

      [
        'section_id' => 2,
        'kode' => 'F8',
        'pertanyaan' => 'Jelaskan status Anda saat ini?',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 1,
      ],

      // =====================
      // STUDI LANJUT
      // =====================
      [
        'section_id' => 5,
        'kode' => 'F18',
        'pertanyaan' => ' Pertanyaan studi lanjut',
        'jenis' => 'label',
        'wajib' => false,
        'tampil_jika' => [
          'F8' => ['4']
        ],
        'urutan' => 1,
      ],
      [
        'section_id' => 5,
        'kode' => 'F18A',
        'parent_kode' => 'F8',
        'pertanyaan' => 'Sumber biaya',
        'jenis' => 'radio',
        'wajib' => true,
        'tampil_jika' => [
          'F8' => ['4']
        ],
        'urutan' => 2,
      ],

      [
        'section_id' => 5,
        'kode' => 'F18B',
        'parent_kode' => 'F8',
        'pertanyaan' => 'Perguruan Tinggi',
        'jenis' => 'select',
        'wajib' => true,
        'tampil_jika' => [
          'F8' => ['4']
        ],
        'urutan' => 3,
      ],

      [
        'section_id' => 5,
        'kode' => 'F18C',
        'parent_kode' => 'F18B',
        'pertanyaan' => 'Program Studi',
        'jenis' => 'select',
        'wajib' => true,
        'tampil_jika' => [
          'F8' => ['4']
        ],
        'urutan' => 4,
      ],

      [
        'section_id' => 5,
        'kode' => 'F18D',
        'parent_kode' => 'F8',
        'pertanyaan' => 'Tanggal Masuk',
        'jenis' => 'date',
        'wajib' => true,
        'tampil_jika' => [
          'F8' => ['4']
        ],
        'urutan' => 5,
      ],

      // =====================
      // PEKERJAAN
      // =====================

      [
        'section_id' => 3,
        'kode' => 'F502',
        'parent_kode' => 'F8',
        'pertanyaan' => 'Dalam berapa bulan Anda mendapatkan pekerjaan pertama?',
        'jenis' => 'number',
        'wajib' => true,
        'tampil_jika' => [
          'F8' => ['1']
        ],
        'urutan' => 1,
      ],

      [
        'section_id' => 3,
        'kode' => 'F505',
        'parent_kode' => 'F8',
        'pertanyaan' => 'Berapa rata-rata pendapatan Anda per bulan (take home pay)?',
        'jenis' => 'number',
        'wajib' => true,
        'tampil_jika' => [
          'F8' => ['1', '3']
        ],
        'urutan' => 2,
      ],

      [
        'section_id' => 3,
        'kode' => 'F510',
        'pertanyaan' => 'Di mana lokasi tempat Anda bekerja?',
        'jenis' => 'select',
        'wajib' => true,
        'tampil_jika' => [
          'F8' => ['1', '3']
        ],
        'urutan' => 3,
      ],

      [
        'section_id' => 3,
        'kode' => 'F5A1',
        'pertanyaan' => 'Provinsi tempat bekerja',
        'jenis' => 'select',
        'wajib' => true,
        'tampil_jika' => [
          'F8' => ['1','3'],
          'F510' => ['ID']
        ],
        'urutan' => 4,
      ],

      [
        'section_id' => 3,
        'kode' => 'F5A2',
        'parent_kode' => 'F5A1',
        'pertanyaan' => 'Kabupaten/Kota tempat bekerja',
        'jenis' => 'select',
        'wajib' => true,
        'tampil_jika' => [
          'F8' => ['1','3'],
          'F510' => ['ID']
        ],
        'urutan' => 5,
      ],

      [
        'section_id' => 3,
        'kode' => 'F1101',
        'parent_kode' => 'F8',
        'pertanyaan' => 'Apa jenis perusahaan/instansi/institusi tempat anda bekerja sekarang?',
        'jenis' => 'radio',
        'wajib' => true,
        'tampil_jika' => [
          'F8' => ['1']
        ],
        'urutan' => 5,
      ],

      [
        'section_id' => 3,
        'kode' => 'F1102',
        'parent_kode' => 'F1101',
        'pertanyaan' => 'Lainnya, tuliskan',
        'jenis' => 'text',
        'wajib' => true,
        'tampil_jika' => [
          'F1101' => ['5']
        ],
        'urutan' => 6,
      ],

      [
        'section_id' => 3,
        'kode' => 'F5B',
        'parent_kode' => 'F8',
        'pertanyaan' => 'Apa nama perusahaan/kantor tempat Anda bekerja?',
        'jenis' => 'text',
        'wajib' => true,
        'tampil_jika' => [
          'F8' => ['1']
        ],
        'urutan' => 7,
      ],

      [
        'section_id' => 3,
        'kode' => 'F5D',
        'parent_kode' => 'F8',
        'pertanyaan' => 'Apa tingkat tempat kerja Anda?',
        'jenis' => 'radio',
        'wajib' => true,
        'tampil_jika' => [
          'F8' => ['1', '3']
        ],
        'urutan' => 8,
      ],

      [
        'section_id' => 3,
        'kode' => 'F14',
        'parent_kode' => 'F8',
        'pertanyaan' => 'Seberapa erat hubungan bidang studi dengan pekerjaan Anda?',
        'jenis' => 'radio',
        'wajib' => true,
        'tampil_jika' => [
          'F8' => ['1', '3']
        ],
        'urutan' => 9,
      ],

      [
        'section_id' => 3,
        'kode' => 'F15',
        'parent_kode' => 'F8',
        'pertanyaan' => 'Tingkat pendidikan apa yang paling tepat untuk pekerjaan anda saat ini?',
        'jenis' => 'radio',
        'wajib' => true,
        'tampil_jika' => [
          'F8' => ['1', '3']
        ],
        'urutan' => 10,
      ],

      // =====================
      // PEMBIAYAAN KULIAH
      // =====================

      [
        'section_id' => 1,
        'kode' => 'F1201',
        'pertanyaan' => 'Sebutkan sumber dana dalam pembiayaan kuliah?',
        'jenis' => 'radio',
        'wajib' => true,
        'tampil_jika' => [
          'F8' => ['1', '2', '3', '5']
        ],
        'urutan' => 20,
      ],
      [
        'section_id' => 1,
        'kode' => 'F1202',
        'parent_kode' => 'F1201',
        'pertanyaan' => 'Lainnya, tuliskan',
        'jenis' => 'text',
        'wajib' => true,
        'tampil_jika' => [
          'F8' => ['1', '2', '3', '5'],
          'F1201' => ['7']
        ],
        'urutan' => 21,
      ],

      // =====================
      // F17A
      // =====================

      [
        'section_id' => 7,
        'kode' => 'F17A',
        'pertanyaan' => 'Pada saat lulus, pada tingkat mana kompetensi di bawah ini Anda kuasai?',
        'jenis' => 'text',
        'wajib' => false,
        'urutan' => 15,
      ],

      [
        'section_id' => 7,
        'kode' => 'F1761',
        'pertanyaan' => 'Etika',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 16,
      ],

      [
        'section_id' => 7,
        'kode' => 'F1763',
        'pertanyaan' => 'Keahlian berdasarkan bidang ilmu',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 17,
      ],

      [
        'section_id' => 7,
        'kode' => 'F1765',
        'pertanyaan' => 'Bahasa Inggris',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 18,
      ],

      [
        'section_id' => 7,
        'kode' => 'F1767',
        'pertanyaan' => 'Penggunaan Teknologi Informasi',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 19,
      ],

      [
        'section_id' => 7,
        'kode' => 'F1769',
        'pertanyaan' => 'Komunikasi',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 20,
      ],

      [
        'section_id' => 7,
        'kode' => 'F1771',
        'pertanyaan' => 'Kerja sama tim',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 21,
      ],

      [
        'section_id' => 7,
        'kode' => 'F1773',
        'pertanyaan' => 'Pengembangan',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 22,
      ],

// =====================
// F17B
// =====================

      [
        'section_id' => 7,
        'kode' => 'F17B',
        'pertanyaan' => 'Pada saat ini, pada tingkat mana kompetensi di bawah ini diperlukan dalam pekerjaan?',
        'jenis' => 'text',
        'wajib' => false,
        'urutan' => 23,
      ],

      [
        'section_id' => 7,
        'kode' => 'F1762',
        'pertanyaan' => 'Etika',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 24,
      ],

      [
        'section_id' => 7,
        'kode' => 'F1764',
        'pertanyaan' => 'Keahlian berdasarkan bidang ilmu',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 25,
      ],

      [
        'section_id' => 7,
        'kode' => 'F1766',
        'pertanyaan' => 'Bahasa Inggris',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 26,
      ],

      [
        'section_id' => 7,
        'kode' => 'F1768',
        'pertanyaan' => 'Penggunaan Teknologi Informasi',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 27,
      ],

      [
        'section_id' => 7,
        'kode' => 'F1770',
        'pertanyaan' => 'Komunikasi',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 28,
      ],

      [
        'section_id' => 7,
        'kode' => 'F1772',
        'pertanyaan' => 'Kerja sama tim',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 29,
      ],

      [
        'section_id' => 7,
        'kode' => 'F1774',
        'pertanyaan' => 'Pengembangan',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 30,
      ],
      // =====================
      // PEMBELAJARAN
      // =====================

      [
        'section_id' => 8,
        'kode' => 'F2',
        'pertanyaan' => 'Menurut anda seberapa besar penekanan pada metode pembelajaran dibawah ini dilaksanakan di program studi anda?',
        'jenis' => 'text',
        'wajib' => false,
        'urutan' => 31,
      ],

      [
        'section_id' => 8,
        'kode' => 'F21',
        'parent_kode' => 'F2',
        'pertanyaan' => 'Perkuliahan',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 32,
      ],

      [
        'section_id' => 8,
        'kode' => 'F22',
        'parent_kode' => 'F2',
        'pertanyaan' => 'Demonstrasi',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 33,
      ],

      [
        'section_id' => 8,
        'kode' => 'F23',
        'parent_kode' => 'F2',
        'pertanyaan' => 'Partisipasi dalam proyek riset',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 34,
      ],

      [
        'section_id' => 8,
        'kode' => 'F24',
        'parent_kode' => 'F2',
        'pertanyaan' => 'Magang',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 35,
      ],

      [
        'section_id' => 8,
        'kode' => 'F25',
        'parent_kode' => 'F2',
        'pertanyaan' => 'Praktikum',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 36,
      ],

      [
        'section_id' => 8,
        'kode' => 'F26',
        'parent_kode' => 'F2',
        'pertanyaan' => 'Kerja Lapangan',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 37,
      ],

      [
        'section_id' => 8,
        'kode' => 'F27',
        'parent_kode' => 'F2',
        'pertanyaan' => 'Diskusi',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 38,
      ],

      // =====================
      // PENCARI KERJA
      // =====================

      [
        'section_id' => 6,
        'kode' => 'F301',
        'pertanyaan' => 'Kapan anda mulai mencari pekerjaan?',
        'jenis' => 'radio',
        'wajib' => true,
        'tampil_jika' => [
          'F8' => ['1', '2', '3', '5']
        ],
        'urutan' => 1,
      ],

      [
        'section_id' => 6,
        'kode' => 'F302',
        'parent_kode' => 'F301',
        'pertanyaan' => 'Berapa bulan mencari pekerjaan sebelum lulus?',
        'jenis' => 'number',
        'wajib' => true,
        'tampil_jika' => [
          'F301' => ['1']
        ],
        'urutan' => 2,
      ],

      [
        'section_id' => 6,
        'kode' => 'F303',
        'parent_kode' => 'F301',
        'pertanyaan' => 'Berapa bulan mencari pekerjaan sesudah lulus?',
        'jenis' => 'number',
        'wajib' => true,
        'tampil_jika' => [
          'F301' => ['2']
        ],
        'urutan' => 3,
      ],

      [
        'section_id' => 6,
        'kode' => 'F4',
        'pertanyaan' => 'Bagaimana anda mencari pekerjaan tersebut?',
        'jenis' => 'checkbox',
        'wajib' => true,
        'tampil_jika' => [
          'F8' => ['1', '2', '3', '5']
        ],
        'urutan' => 4,
      ],

      [
        'section_id' => 6,
        'kode' => 'F416',
        'parent_kode' => 'F4',
        'pertanyaan' => 'Lainnya',
        'jenis' => 'text',
        'wajib' => true,
        'tampil_jika' => [
          'F4' => ['F415']
        ],
        'urutan' => 5,
      ],


      [
        'section_id' => 6,
        'kode' => 'F6',
        'pertanyaan' => 'Berapa perusahaan/instansi/institusi yang sudah anda lamar (lewat surat atau e
mail) sebelum anda memeroleh pekerjaan pertama? (Perusahaan/instansi/institusi)',
        'jenis' => 'number',
        'wajib' => true,
        'tampil_jika' => [
          'F8' => ['1', '2', '3', '5']
        ],
        'urutan' => 6,
      ],

      [
        'section_id' => 6,
        'kode' => 'F7',
        'pertanyaan' => 'Berapa banyak perusahaan/instansi/institusi yang merespons lamaran anda?
(Perusahaan/instansi/institusi)',
        'jenis' => 'number',
        'wajib' => true,
        'tampil_jika' => [
          'F8' => ['1', '2', '3', '5']
        ],
        'urutan' => 7,
      ],

      [
        'section_id' => 6,
        'kode' => 'F7A',
        'pertanyaan' => 'Berapa banyak perusahaan/instansi/institusi yang mengundang anda untuk
wawancara? (Perusahaan/instansi/institusi)',
        'jenis' => 'number',
        'wajib' => true,
        'tampil_jika' => [
          'F8' => ['1', '2', '3', '5']
        ],
        'urutan' => 8,
      ],

      [
        'section_id' => 6,
        'kode' => 'F1001',
        'pertanyaan' => 'Apakah anda aktif mencari pekerjaan dalam 4 minggu terakhir? Pilihlah satu jawaban',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 9,
      ],

      [
        'section_id' => 6,
        'kode' => 'F1002',
        'parent_kode' => 'F1001',
        'pertanyaan' => 'Lainnya',
        'jenis' => 'text',
        'wajib' => true,
        'tampil_jika' => [
          'F1001' => ['5']
        ],
        'urutan' => 10,
      ],

      [
        'section_id' => 6,
        'kode' => 'F16',
        'pertanyaan' => ' Jika menurut anda pekerjaan anda saat ini tidak sesuai dengan : pendidikan anda, mengapa anda mengambilnya? Jawaban bisa lebih dari satu',
        'jenis' => 'checkbox',
        'wajib' => true,
        'urutan' => 11,
      ],

      [
        'section_id' => 6,
        'kode' => 'F1614',
        'parent_kode' => 'F1613',
        'pertanyaan' => 'Lainnya',
        'jenis' => 'text',
        'wajib' => true,
        'tampil_jika' => [
          'F16' => ['F1613']

        ],
        'urutan' => 12,
      ],

    ];

    foreach ($pertanyaans as $item) {

      $item['parent_kode'] = $item['parent_kode'] ?? null;
      $item['tampil_jika'] = $item['tampil_jika'] ?? null;
      $item['aktif'] = true;

      TracerPertanyaan::updateOrCreate(
        [
          'kode' => $item['kode']
        ],
        $item
      );
    }

    $urutan = [
      'F8'    => 1,

      // STUDI LANJUT
      'F18'   => 2,
      'F18A'  => 3,
      'F18B'  => 4,
      'F18C'  => 5,
      'F18D'  => 6,

      // PEKERJAAN
      'F502'  => 7,
      'F505'  => 8,
      'F510'  => 9,
      'F5A1'  => 10,
      'F5A2'  => 11,
      'F1101' => 12,
      'F1102' => 13,
      'F5B'   => 14,
      'F5D'   => 15,
      'F14'   => 16,
      'F15'   => 17,

      // PEMBIAYAAN
      'F1201' => 18,
      'F1202' => 19,

      // KOMPETENSI
      'F17A'  => 20,
      'F1761' => 21,
      'F1763' => 22,
      'F1765' => 23,
      'F1767' => 24,
      'F1769' => 25,
      'F1771' => 26,
      'F1773' => 27,

      'F17B'  => 28,
      'F1762' => 29,
      'F1764' => 30,
      'F1766' => 31,
      'F1768' => 32,
      'F1770' => 33,
      'F1772' => 34,
      'F1774' => 35,

      // PEMBELAJARAN
      'F2'    => 36,
      'F21'   => 37,
      'F22'   => 38,
      'F23'   => 39,
      'F24'   => 40,
      'F25'   => 41,
      'F26'   => 42,
      'F27'   => 43,

      // PENCARI KERJA
      'F301'  => 44,
      'F302'  => 45,
      'F303'  => 46,
      'F4'    => 47,
      'F416'  => 48,
      'F6'    => 49,
      'F7'    => 50,
      'F7A'   => 51,
      'F1001' => 52,
      'F1002' => 53,
      'F16'   => 54,
      'F1614' => 55,

      // OPSI CHECKBOX
      'F1601' => 56,
      'F1602' => 57,
      'F1603' => 58,
      'F1604' => 59,
      'F1605' => 60,
      'F1606' => 61,
      'F1607' => 62,
      'F1608' => 63,
      'F1609' => 64,
      'F1610' => 65,
      'F1611' => 66,
      'F1612' => 67,
      'F1613' => 68,
      'F1614' => 69,
    ];

    foreach ($urutan as $kode => $urutan) {
      TracerPertanyaan::where('kode', $kode)
        ->update([
          'urutan' => $urutan
        ]);
    }
  }
}
