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
          'F1613' => ['1']
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
      'F8' => 1,
      'F502' => 2,
      'F505' => 3,
      'F510' => 4,
      'F5A1' => 5,
      'F5A2' => 6,
      'F1101' => 7,
      'F1102' => 8,
      'F5B' => 9,
      'F5D' => 10,
      'F1201' => 11,
      'F1202' => 12,
      'F14' => 13,
      'F15' => 14,

      'F17A' => 15,

      'F1761' => 16,
      'F1763' => 17,
      'F1765' => 18,
      'F1767' => 19,
      'F1769' => 20,
      'F1771' => 21,
      'F1773' => 22,

      'F17B' => 23,

      'F1762' => 24,
      'F1764' => 25,
      'F1766' => 26,
      'F1768' => 27,
      'F1770' => 28,
      'F1772' => 29,
      'F1774' => 30,

      'F2' => 31,

      'F21' => 32,
      'F22' => 33,
      'F23' => 34,
      'F24' => 35,
      'F25' => 36,
      'F26' => 37,
      'F27' => 38,

      'F301' => 39,
      'F302' => 40,
      'F303' => 41,

      'F4' => 42,
      'F401' => 43,
      'F402' => 44,
      'F403' => 45,
      'F404' => 46,
      'F405' => 47,
      'F406' => 48,
      'F407' => 49,
      'F408' => 50,
      'F409' => 51,
      'F410' => 52,
      'F411' => 53,
      'F412' => 54,
      'F413' => 55,
      'F414' => 56,
      'F416' => 57,

      'F6' => 58,
      'F7' => 59,
      'F7A' => 60,

      'F1001' => 61,
      'F1002' => 62,

      'F16' => 63,

      'F1601' => 64,
      'F1602' => 65,
      'F1603' => 66,
      'F1604' => 67,
      'F1605' => 68,
      'F1606' => 69,
      'F1607' => 70,
      'F1608' => 71,
      'F1609' => 72,
      'F1610' => 73,
      'F1611' => 74,
      'F1612' => 75,
      'F1613' => 76,
      'F1614' => 77,
    ];

    foreach ($urutan as $kode => $urutan) {
      TracerPertanyaan::where('kode', $kode)
        ->update([
          'urutan' => $urutan
        ]);
    }
  }
}
