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
      // BIODATA
      // =====================

      [
        'section_id' => 1,
        'kode' => 'BIO01',
        'pertanyaan' => 'NPWP',
        'jenis' => 'text',
        'wajib' => false,
      ],

      [
        'section_id' => 1,
        'kode' => 'BIO02',
        'pertanyaan' => 'Email Aktif',
        'jenis' => 'text',
        'wajib' => true,

      ],

      [
        'section_id' => 1,
        'kode' => 'BIO03',
        'pertanyaan' => 'Nomor Telepon / HP / WhatsApp',
        'jenis' => 'text',
        'wajib' => true,
        ],

      [
        'section_id' => 1,
        'kode' => 'BIO04',
        'pertanyaan' => 'Alamat domisili saat ini',
        'jenis' => 'text',
        'wajib' => true,

      ],

      [
        'section_id' => 1,
        'kode' => 'BIO05',
        'pertanyaan' => 'Negara',
        'jenis' => 'select',
        'wajib' => true,
        'urutan' => 5,
      ],

      [
        'section_id' => 1,
        'kode' => 'BIO06',
        'pertanyaan' => 'Provinsi',
        'jenis' => 'select',
        'wajib' => true,
        'urutan' => 6,
        'tampil_jika' => [
          'BIO05' => ['103']
        ],
      ],

      [
        'section_id' => 1,
        'kode' => 'BIO07',
        'pertanyaan' => 'Kabupaten/Kota',
        'jenis' => 'select',
        'wajib' => true,
        'urutan' => 7,
        'tampil_jika' => [
          'BIO05' => ['103']
        ],
      ],


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
        'urutan' => 2,
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
        'urutan' => 3,
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
        'urutan' => 4,
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
        'urutan' => 5,
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
        'urutan' => 6,
      ],

      // =====================
      // PEKERJAAN
      // =====================

      [
        'section_id' => 3,
        'kode' => 'F502',
        'parent_kode' => 'F8',
        'pertanyaan' => 'Dalam berapa bulan Anda mendapatkan pekerjaan pertama? (Kelulusan dihitung berdasarkan bulan yudisium dan masa tunggu kerja dihitung 0, jika
bekerja sebelum lulus)',
        'jenis' => 'number',
        'wajib' => true,
        'tampil_jika' => [
          'F8' => ['1']
        ],
        'urutan' => 7,
      ],

      [
        'section_id' => 3,
        'kode' => 'F505',
        'parent_kode' => 'F8',
        'pertanyaan' => 'Berapa rata-rata pendapatan Anda per bulan (take home pay)? (take home pay adalah jumlah total penghasilan yang diterima ditambah
tunjangan/bonus) ',
        'jenis' => 'number',
        'wajib' => true,
        'tampil_jika' => [
          'F8' => ['1', '3']
        ],
        'urutan' => 8,
      ],

      [
        'section_id' => 3,
        'kode' => 'F510',
        'pertanyaan' => 'Di mana lokasi tempat Anda bekerja?',
        'jenis' => 'label',
        'wajib' => false,
        'tampil_jika' => [
          'F8' => ['1','3'],
        ],
        'urutan' => 9,
      ],

      [
        'section_id' => 3,
        'kode' => 'F5A0',
        'pertanyaan' => 'Negara',
        'jenis' => 'select',
        'wajib' => true,
        'tampil_jika' => [
          'F8' => ['1','3'],
        ],
        'urutan' => 9,
      ],
      [
        'section_id' => 3,
        'kode' => 'F5A1',
        'pertanyaan' => 'Provinsi tempat bekerja',
        'jenis' => 'select',
        'wajib' => true,
        'tampil_jika' => [
          'F8' => ['1','3'],
          'F5A0' => ['ID']
        ],
        'urutan' => 10,
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
          'F5A0' => ['ID']
        ],
        'urutan' => 11,
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
        'urutan' => 12,
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
        'urutan' => 13,
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
        'urutan' => 14,
      ],

      [
        'section_id' => 3,
        'kode' => 'F5D',
        'parent_kode' => 'F8',
        'pertanyaan' => 'Apa ruang lingkup tempat Anda bekerja?',
        'jenis' => 'radio',
        'wajib' => true,
        'tampil_jika' => [
          'F8' => ['1', '3']
        ],
        'urutan' => 15,
      ],

      [
        'section_id' => 3,
        'kode' => 'F14',
        'parent_kode' => 'F8',
        'pertanyaan' => 'Seberapa relevan bidang studi dengan pekerjaan Anda saat ini?',
        'jenis' => 'radio',
        'wajib' => true,
        'tampil_jika' => [
          'F8' => ['1', '3']
        ],
        'urutan' => 16,
      ],

      [
        'section_id' => 3,
        'kode' => 'F15',
        'parent_kode' => 'F8',
        'pertanyaan' => ' Tingkat kesesuaian jenjang pendidikan untuk pekerjaan Anda saat ini?',
        'jenis' => 'radio',
        'wajib' => true,
        'tampil_jika' => [
          'F8' => ['1', '3']
        ],
        'urutan' => 17,
      ],

      // =====================
      // PEMBIAYAAN KULIAH
      // =====================

      [
        'section_id' => 9,
        'kode' => 'F1201',
        'pertanyaan' => 'Sebutkan sumber dana dalam pembiayaan kuliah?',
        'jenis' => 'radio',
        'wajib' => true,
        'tampil_jika' => [
          'F8' => ['1', '2', '3', '5']
        ],
        'urutan' => 18,
      ],
      [
        'section_id' => 9,
        'kode' => 'F1202',
        'parent_kode' => 'F1201',
        'pertanyaan' => 'Lainnya, tuliskan',
        'jenis' => 'text',
        'wajib' => true,
        'tampil_jika' => [
          'F8' => ['1', '2', '3', '5'],
          'F1201' => ['7']
        ],
        'urutan' => 19,
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
        'urutan' => 20,
      ],

      [
        'section_id' => 7,
        'kode' => 'F1761',
        'pertanyaan' => 'Etika',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 21,
      ],

      [
        'section_id' => 7,
        'kode' => 'F1763',
        'pertanyaan' => 'Keahlian berdasarkan bidang ilmu',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 22,
      ],

      [
        'section_id' => 7,
        'kode' => 'F1765',
        'pertanyaan' => 'Bahasa Inggris',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 23,
      ],

      [
        'section_id' => 7,
        'kode' => 'F1767',
        'pertanyaan' => 'Penggunaan Teknologi Informasi',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 24,
      ],

      [
        'section_id' => 7,
        'kode' => 'F1769',
        'pertanyaan' => 'Komunikasi',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 25,
      ],

      [
        'section_id' => 7,
        'kode' => 'F1771',
        'pertanyaan' => 'Kerja sama tim',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 26,
      ],

      [
        'section_id' => 7,
        'kode' => 'F1773',
        'pertanyaan' => 'Pengembangan Diri',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 27,
      ],

      [
        'section_id' => 7,
        'kode' => 'F1775',
        'pertanyaan' => 'Berpikir kritis',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 28,
      ],[
        'section_id' => 7,
        'kode' => 'F1777',
        'pertanyaan' => 'Kreativitas',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 29,
      ],[
        'section_id' => 7,
        'kode' => 'F1779',
        'pertanyaan' => 'Kewirausahaan',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 30,
      ],[
        'section_id' => 7,
        'kode' => 'F1781',
        'pertanyaan' => 'Adaptasi',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 31,
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
        'urutan' => 32,
      ],

      [
        'section_id' => 7,
        'kode' => 'F1762',
        'pertanyaan' => 'Etika',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 33,
      ],

      [
        'section_id' => 7,
        'kode' => 'F1764',
        'pertanyaan' => 'Keahlian berdasarkan bidang ilmu',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 34,
      ],

      [
        'section_id' => 7,
        'kode' => 'F1766',
        'pertanyaan' => 'Bahasa Inggris',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 35,
      ],

      [
        'section_id' => 7,
        'kode' => 'F1768',
        'pertanyaan' => 'Penggunaan Teknologi Informasi',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 36,
      ],

      [
        'section_id' => 7,
        'kode' => 'F1770',
        'pertanyaan' => 'Komunikasi',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 37,
      ],

      [
        'section_id' => 7,
        'kode' => 'F1772',
        'pertanyaan' => 'Kerja sama tim',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 38,
      ],

      [
        'section_id' => 7,
        'kode' => 'F1774',
        'pertanyaan' => 'Pengembangan Diri',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 39,
      ],

      [
        'section_id' => 7,
        'kode' => 'F1776',
        'pertanyaan' => 'Berpikir kritis',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 40,
      ],[
        'section_id' => 7,
        'kode' => 'F1778',
        'pertanyaan' => 'Kreativitas',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 41,
      ],[
        'section_id' => 7,
        'kode' => 'F1780',
        'pertanyaan' => 'Kewirausahaan',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 42,
      ],[
        'section_id' => 7,
        'kode' => 'F1782',
        'pertanyaan' => 'Adaptasi',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 43,
      ],

      // =====================
      // PEMBELAJARAN
      // =====================

      [
        'section_id' => 8,
        'kode' => 'F2',
        'pertanyaan' => 'Menurut Anda seberapa besar penekanan pada bentuk/metode pembelajaran di
bawah ini dilaksanakan di program studi tempat Anda kuliah? (Jika tidak ada maka pilih
Tidak Ada)',
        'jenis' => 'text',
        'wajib' => false,
        'urutan' => 44,
      ],

      [
        'section_id' => 8,
        'kode' => 'F21',
        'parent_kode' => 'F2',
        'pertanyaan' => 'Perkuliahan',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 45,
      ],

      [
        'section_id' => 8,
        'kode' => 'F22',
        'parent_kode' => 'F2',
        'pertanyaan' => 'Mendemonstrasikan',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 46,
      ],

      [
        'section_id' => 8,
        'kode' => 'F23',
        'parent_kode' => 'F2',
        'pertanyaan' => ' Penelitian/partisipasi dalam proyek riset',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 47,
      ],

      [
        'section_id' => 8,
        'kode' => 'F24',
        'parent_kode' => 'F2',
        'pertanyaan' => ' Magang/praktik kerja ',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 48,
      ],

      [
        'section_id' => 8,
        'kode' => 'F25',
        'parent_kode' => 'F2',
        'pertanyaan' => 'Praktikum',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 49,
      ],

      [
        'section_id' => 8,
        'kode' => 'F26',
        'parent_kode' => 'F2',
        'pertanyaan' => 'Kerja Lapangan',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 50,
      ],

      [
        'section_id' => 8,
        'kode' => 'F27',
        'parent_kode' => 'F2',
        'pertanyaan' => 'Diskusi',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 51,
      ],

      [
        'section_id' => 8,
        'kode' => 'F28',
        'parent_kode' => 'F2',
        'pertanyaan' => 'Responsi/tutorial',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 51,
      ],

      [
        'section_id' => 8,
        'kode' => 'F29',
        'parent_kode' => 'F2',
        'pertanyaan' => 'Seminar',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 51,
      ],[
        'section_id' => 8,
        'kode' => 'F30',
        'parent_kode' => 'F2',
        'pertanyaan' => 'Studio',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 51,
      ],[
        'section_id' => 8,
        'kode' => 'F31',
        'parent_kode' => 'F2',
        'pertanyaan' => 'Perancangan',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 51,
      ],[
        'section_id' => 8,
        'kode' => 'F32',
        'parent_kode' => 'F2',
        'pertanyaan' => 'Pengembangan (misal produk/karya seni)',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 51,
      ],[
        'section_id' => 8,
        'kode' => 'F33',
        'parent_kode' => 'F2',
        'pertanyaan' => 'Tugas akhir',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 51,
      ],[
        'section_id' => 8,
        'kode' => 'F34',
        'parent_kode' => 'F2',
        'pertanyaan' => 'Pelatihan bela negara',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 51,
      ],[
        'section_id' => 8,
        'kode' => 'F35',
        'parent_kode' => 'F2',
        'pertanyaan' => 'Pertukaran pelajar',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 51,
      ],[
        'section_id' => 8,
        'kode' => 'F36',
        'parent_kode' => 'F2',
        'pertanyaan' => 'Wirausaha',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 51,
      ],[
        'section_id' => 8,
        'kode' => 'F37',
        'parent_kode' => 'F2',
        'pertanyaan' => 'Pengabdian kepada masyarakat',
        'jenis' => 'radio',
        'wajib' => true,
        'urutan' => 51,
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
          'F8' => ['1', '3', '5']
        ],
        'urutan' => 52,
      ],

      [
        'section_id' => 6,
        'kode' => 'F302',
        'parent_kode' => 'F301',
        'pertanyaan' => 'Berapa bulan mencari pekerjaan sebelum lulus?',
        'jenis' => 'number',
        'wajib' => true,
        'tampil_jika' => [
          'F8' => ['1', '3', '5'],
          'F301' => ['1']
        ],
        'urutan' => 53,
      ],

      [
        'section_id' => 6,
        'kode' => 'F303',
        'parent_kode' => 'F301',
        'pertanyaan' => 'Berapa bulan mencari pekerjaan sesudah lulus?',
        'jenis' => 'number',
        'wajib' => true,
        'tampil_jika' => [
          'F8' => ['1', '3', '5'],
          'F301' => ['2']
        ],
        'urutan' => 54,
      ],

      [
        'section_id' => 6,
        'kode' => 'F4',
        'pertanyaan' => 'Bagaimana anda mencari pekerjaan tersebut?',
        'jenis' => 'checkbox',
        'wajib' => true,
        'tampil_jika' => [
          'F8' => ['1', '3', '5'],
        ],
        'urutan' => 55,
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
        'urutan' => 56,
      ],


      [
        'section_id' => 6,
        'kode' => 'F6',
        'pertanyaan' => 'Berapa perusahaan/instansi/institusi yang sudah anda lamar (lewat surat atau e
mail) sebelum anda memeroleh pekerjaan pertama? (Perusahaan/instansi/institusi)',
        'jenis' => 'number',
        'wajib' => true,
        'tampil_jika' => [
         'F8' => ['1', '3', '5'],
        ],
        'urutan' => 57,
      ],

      [
        'section_id' => 6,
        'kode' => 'F7',
        'pertanyaan' => 'Berapa banyak perusahaan/instansi/institusi yang merespons lamaran anda?
(Perusahaan/instansi/institusi)',
        'jenis' => 'number',
        'wajib' => true,
        'tampil_jika' => [
         'F8' => ['1', '3', '5'],
        ],
        'urutan' => 58,
      ],

      [
        'section_id' => 6,
        'kode' => 'F7A',
        'pertanyaan' => 'Berapa banyak perusahaan/instansi/institusi yang mengundang anda untuk
wawancara? (Perusahaan/instansi/institusi)',
        'jenis' => 'number',
        'wajib' => true,
        'tampil_jika' => [
         'F8' => ['1', '3', '5'],
        ],
        'urutan' => 59,
      ],

      [
        'section_id' => 6,
        'kode' => 'F1001',
        'pertanyaan' => 'Apakah anda aktif mencari pekerjaan dalam 4 minggu terakhir? Pilihlah satu jawaban',
        'jenis' => 'radio',
        'wajib' => true,
        'tampil_jika' => [
          'F8' => ['1', '3', '5'],
        ],
        'urutan' => 60,
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
        'urutan' => 61,
      ],

      [
        'section_id' => 6,
        'kode' => 'F16',
        'pertanyaan' => ' Jika menurut anda pekerjaan anda saat ini tidak sesuai dengan : pendidikan anda, mengapa anda mengambilnya? Jawaban bisa lebih dari satu',
        'jenis' => 'checkbox',
        'wajib' => true,
        'tampil_jika' => [
          'F8' => ['1', '3', '5'],
        ],
        'urutan' => 62,
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
        'urutan' => 63,
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

      // =====================
      // BIODATA
      // =====================
      'BIO01' => 1,
      'BIO02' => 2,
      'BIO03' => 3,
      'BIO04' => 4,
      'BIO05' => 5,
      'BIO06' => 6,
      'BIO07' => 7,

      // =====================
      // STATUS
      // =====================
      'F8'    => 8,

      // =====================
      // STUDI LANJUT
      // =====================
      'F18'   => 9,
      'F18A'  => 10,
      'F18B'  => 11,
      'F18C'  => 12,
      'F18D'  => 13,

      // =====================
      // PEKERJAAN
      // =====================
      'F502'  => 14,
      'F505'  => 15,
      'F510'  => 16,
      'F5A0'  => 17,
      'F5A1'  => 18,
      'F5A2'  => 19,
      'F1101' => 20,
      'F1102' => 21,
      'F5B'   => 22,
      'F5D'   => 23,
      'F14'   => 24,
      'F15'   => 25,

      // =====================
      // PENCARI KERJA
      // =====================
      'F301'  => 26,
      'F302'  => 27,
      'F303'  => 28,
      'F4'    => 29,
      'F416'  => 30,
      'F6'    => 31,
      'F7'    => 32,
      'F7A'   => 33,
      'F1001' => 34,
      'F1002' => 35,
      'F16'   => 36,
      'F1614' => 37,

      // =====================
      // PEMBIAYAAN KULIAH
      // =====================
      'F1201' => 38,
      'F1202' => 39,

      // =====================
      // KOMPETENSI SAAT LULUS
      // =====================
      'F17A'  => 40,
      'F1761' => 41,
      'F1763' => 42,
      'F1765' => 43,
      'F1767' => 44,
      'F1769' => 45,
      'F1771' => 46,
      'F1773' => 47,
      'F1775' => 48,
      'F1777' => 49,
      'F1779' => 50,
      'F1781' => 51,

      // =====================
      // KOMPETENSI SAAT INI
      // =====================
      'F17B'  => 52,
      'F1762' => 53,
      'F1764' => 54,
      'F1766' => 55,
      'F1768' => 56,
      'F1770' => 57,
      'F1772' => 58,
      'F1774' => 59,
      'F1776' => 60,
      'F1778' => 61,
      'F1780' => 62,
      'F1782' => 63,

      // =====================
      // PEMBELAJARAN
      // =====================
      'F2'    => 64,
      'F21'   => 65,
      'F22'   => 66,
      'F23'   => 67,
      'F24'   => 68,
      'F25'   => 69,
      'F26'   => 70,
      'F27'   => 71,
      'F28'   => 72,
      'F29'   => 73,
      'F30'   => 74,
      'F31'   => 75,
      'F32'   => 76,
      'F33'   => 77,
      'F34'   => 78,
      'F35'   => 79,
      'F36'   => 80,
      'F37'   => 81,
    ];

    foreach ($urutan as $kode => $urutan) {
      TracerPertanyaan::where('kode', $kode)
        ->update([
          'urutan' => $urutan
        ]);
    }
  }
}
