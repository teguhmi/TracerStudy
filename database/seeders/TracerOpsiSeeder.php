<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\tracer\TracerOpsi;
use App\Models\tracer\TracerPertanyaan;

class TracerOpsiSeeder extends Seeder
{
  public function run(): void
  {
    $this->seedF8();

    $this->seedF1101();
    $this->seedF5D();
    $this->seedF5C();

    $this->seedF1201();

    $this->seedF14();
    $this->seedF15();

    $this->seedKompetensi();
    $this->seedPembelajaran();

    $this->seedF301();
    $this->seedF1001();

    $this->seedF4();
    $this->seedF16();

    $this->seedF18A();
  }

  private function saveOptions(string $kode, array $options): void
  {
    $pertanyaan = TracerPertanyaan::where('kode', $kode)->first();

    if (!$pertanyaan) {
      return;
    }

    foreach ($options as $urut => $option) {

      TracerOpsi::updateOrCreate(
        [
          'pertanyaan_id' => $pertanyaan->id,
          'nilai' => $option['nilai'],
        ],
        [
          'label' => $option['label'],
          'urutan' => $urut + 1,
          'aktif' => true,
        ]
      );
    }
  }

  private function seedF8(): void
  {
    $this->saveOptions('F8', [
      ['nilai' => '1', 'label' => 'Bekerja (full time / part time)'],
      ['nilai' => '2', 'label' => 'Belum memungkinkan bekerja'],
      ['nilai' => '3', 'label' => 'Wiraswasta'],
      ['nilai' => '4', 'label' => 'Melanjutkan Pendidikan'],
      ['nilai' => '5', 'label' => 'Tidak kerja tetapi sedang mencari kerja'],
    ]);
  }

  private function seedF1101(): void
  {
    $this->saveOptions('F1101', [
      ['nilai' => '1', 'label' => 'Instansi pemerintah'],
      ['nilai' => '6', 'label' => 'BUMN/BUMD'],
      ['nilai' => '7', 'label' => 'Institusi/Organisasi Multilateral'],
      ['nilai' => '2', 'label' => 'Organisasi non-profit/Lembaga Swadaya Masyarakat'],
      ['nilai' => '3', 'label' => 'Perusahaan swasta'],
      ['nilai' => '4', 'label' => 'Wiraswasta/perusahaan sendiri'],
      ['nilai' => '5', 'label' => 'Lainnya'],
    ]);
  }

  private function seedF5D(): void
  {
    $this->saveOptions('F5D', [
      ['nilai' => '1', 'label' => 'Lokal/Wilayah/Wiraswasta tidak berbadan hukum'],
      ['nilai' => '2', 'label' => 'Nasional/Wiraswasta berbadan hukum'],
      ['nilai' => '3', 'label' => 'Multinasional/Internasional'],
    ]);
  }

  private function seedF5C(): void
  {
    $this->saveOptions('F5C', [
      ['nilai' => '1', 'label' => 'Founder'],
      ['nilai' => '2', 'label' => 'Co-Founder'],
      ['nilai' => '3', 'label' => 'Staff'],
      ['nilai' => '4', 'label' => 'Freelance/Kerja Lepas'],
    ]);
  }

  private function seedF1201(): void
  {
    $this->saveOptions('F1201', [
      ['nilai' => '1', 'label' => 'Biaya Sendiri/Keluarga'],
      ['nilai' => '2', 'label' => 'Beasiswa ADIK'],
      ['nilai' => '3', 'label' => 'Beasiswa BIDIKMISI'],
      ['nilai' => '4', 'label' => 'Beasiswa PPA'],
      ['nilai' => '5', 'label' => 'Beasiswa AFIRMASI'],
      ['nilai' => '6', 'label' => 'Beasiswa Perusahaan/Swasta'],
      ['nilai' => '7', 'label' => 'Lainnya'],
    ]);
  }

  private function seedF14(): void
  {
    $this->saveOptions('F14', [
      ['nilai' => '1', 'label' => 'Sangat Erat'],
      ['nilai' => '2', 'label' => 'Erat'],
      ['nilai' => '3', 'label' => 'Cukup Erat'],
      ['nilai' => '4', 'label' => 'Kurang Erat'],
      ['nilai' => '5', 'label' => 'Tidak Sama Sekali'],
    ]);
  }

  private function seedF15(): void
  {
    $this->saveOptions('F15', [
      ['nilai' => '1', 'label' => 'Setingkat Lebih Tinggi'],
      ['nilai' => '2', 'label' => 'Tingkat Yang Sama'],
      ['nilai' => '3', 'label' => 'Setingkat Lebih Rendah'],
      ['nilai' => '4', 'label' => 'Tidak Perlu Pendidikan Tinggi'],
    ]);
  }

  private function seedKompetensi(): void
  {
    $kodePertanyaan = [
      'F1761','F1762',
      'F1763','F1764',
      'F1765','F1766',
      'F1767','F1768',
      'F1769','F1770',
      'F1771','F1772',
      'F1773','F1774',
    ];

    $opsi = [
      [1, 'Sangat Rendah'],
      [2, 'Rendah'],
      [3, 'Netral'],
      [4, 'Tinggi'],
      [5, 'Sangat Tinggi'],
    ];

    foreach ($kodePertanyaan as $kode) {

      $pertanyaan = TracerPertanyaan::where('kode', $kode)->first();

      if (!$pertanyaan) {
        continue;
      }

      foreach ($opsi as $urutan => $item) {

        TracerOpsi::updateOrCreate(
          [
            'pertanyaan_id' => $pertanyaan->id,
            'nilai' => $item[0],
          ],
          [
            'label' => $item[1],
            'urutan' => $urutan + 1,
            'aktif' => true,
          ]
        );
      }
    }
  }
  private function seedPembelajaran(): void
  {
    $kodePertanyaans = [
      'F21',
      'F22',
      'F23',
      'F24',
      'F25',
      'F26',
      'F27',
    ];

    $opsi = [
      ['5', 'Tidak Sama Sekali'],
      ['4', 'Kurang Besar'],
      ['3', 'Cukup Besar'],
      ['2', 'Besar'],
      ['1', 'Sangat Besar'],
    ];

    foreach ($kodePertanyaans as $kode) {

      $pertanyaan = TracerPertanyaan::where('kode', $kode)->first();

      if (!$pertanyaan) {
        continue;
      }

      foreach ($opsi as $urutan => $item) {

        TracerOpsi::updateOrCreate(
          [
            'pertanyaan_id' => $pertanyaan->id,
            'nilai' => $item[0],
          ],
          [
            'label' => $item[1],
            'urutan' => $urutan + 1,
            'aktif' => true,
          ]
        );
      }
    }
  }

  private function seedF301(): void
  {
    $this->saveOptions('F301', [
      [
        'nilai' => '1',
        'label' => 'Kira-kira berapa bulan Anda mencari pekerjaan sebelum lulus'
      ],
      [
        'nilai' => '2',
        'label' => 'Kira-kira berapa bulan Anda mencari pekerjaan sesudah lulus'
      ],
      [
        'nilai' => '3',
        'label' => 'Saya tidak mencari kerja'
      ],
    ]);
  }

  private function seedF1001(): void
  {
    $this->saveOptions('F1001', [
      [
        'nilai' => '1',
        'label' => 'Tidak'
      ],
      [
        'nilai' => '2',
        'label' => 'Tidak, tapi saya sedang menunggu hasil lamaran kerja'
      ],
      [
        'nilai' => '3',
        'label' => 'Ya, saya akan mulai bekerja dalam 2 minggu ke depan'
      ],
      [
        'nilai' => '4',
        'label' => 'Ya, tapi saya belum pasti akan bekerja dalam 2 minggu ke depan'
      ],
      [
        'nilai' => '5',
        'label' => 'Lainnya'
      ],
    ]);
  }

  private function seedF4(): void
  {
    $f4 = TracerPertanyaan::where('kode', 'F4')->first();

    if (!$f4) {
      $this->command->error('Pertanyaan F4 belum ditemukan.');
      return;
    }

    $opsiF4 = [
      ['F401', 'Melalui iklan di koran/majalah, brosur'],
      ['F402', 'Melamar ke perusahaan tanpa mengetahui lowongan yang ada'],
      ['F403', 'Pergi ke bursa/pameran kerja'],
      ['F404', 'Mencari lewat internet/iklan online/milis'],
      ['F405', 'Dihubungi oleh perusahaan'],
      ['F406', 'Menghubungi Kemenakertrans'],
      ['F407', 'Menghubungi agen tenaga kerja komersial/swasta'],
      ['F408', 'Memeroleh informasi dari pusat/kantor pengembangan karir fakultas/universitas'],
      ['F409', 'Menghubungi kantor kemahasiswaan/hubungan alumni'],
      ['F410', 'Membangun jejaring (network) sejak masih kuliah'],
      ['F411', 'Melalui relasi (misalnya dosen, orang tua, saudara, teman, dll.)'],
      ['F412', 'Membangun bisnis sendiri'],
      ['F413', 'Melalui penempatan kerja atau magang'],
      ['F414', 'Bekerja di tempat yang sama dengan tempat kerja semasa kuliah'],
      ['F415', 'Lainnya'],
    ];

    foreach ($opsiF4 as $index => $opsi) {

      TracerOpsi::updateOrCreate(
        [
          'pertanyaan_id' => $f4->id,
          'nilai'         => $opsi[0],
        ],
        [
          'label'  => $opsi[1],
          'urutan' => $index + 1,
          'aktif'  => true,
        ]
      );
    }
  }


  private function seedF16(): void
  {
    $this->saveOptions('F16', [
      ['nilai' => 'F1601', 'label' => 'Pekerjaan saya sekarang sudah sesuai dengan pendidikan saya'],
      ['nilai' => 'F1602', 'label' => 'Saya belum mendapatkan pekerjaan yang lebih sesuai'],
      ['nilai' => 'F1603', 'label' => 'Di pekerjaan ini saya memperoleh prospek karir yang baik'],
      ['nilai' => 'F1604', 'label' => 'Saya lebih suka bekerja di area yang tidak berhubungan dengan pendidikan saya'],
      ['nilai' => 'F1605', 'label' => 'Saya dipromosikan ke posisi yang kurang berhubungan dengan pendidikan saya'],
      ['nilai' => 'F1606', 'label' => 'Saya memperoleh pendapatan yang lebih tinggi'],
      ['nilai' => 'F1607', 'label' => 'Pekerjaan saya lebih aman atau terjamin'],
      ['nilai' => 'F1608', 'label' => 'Pekerjaan saya lebih menarik'],
      ['nilai' => 'F1609', 'label' => 'Pekerjaan lebih fleksibel untuk pekerjaan tambahan'],
      ['nilai' => 'F1610', 'label' => 'Lokasi pekerjaan lebih dekat ke rumah'],
      ['nilai' => 'F1611', 'label' => 'Lebih menjamin kebutuhan keluarga'],
      ['nilai' => 'F1612', 'label' => 'Harus menerima pekerjaan yang tidak sesuai pendidikan di awal karir'],
      ['nilai' => 'F1613', 'label' => 'Lainnya'],
    ]);
  }

  private function seedF18A(): void
  {
    $this->saveOptions('F18A', [
      ['nilai' => '1', 'label' => 'Biaya Sendiri'],
      ['nilai' => '2', 'label' => 'Beasiswa'],
    ]);
  }
}
