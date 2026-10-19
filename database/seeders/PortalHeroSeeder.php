<?php

namespace Database\Seeders;

use App\Models\PortalHero;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PortalHeroSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    PortalHero::truncate();

    PortalHero::create([
      'badge'         => 'UNIVERSITAS TERBUKA',
      'title'         => "Terhubung Kembali\nDengan Almamater",
      'subtitle'      => 'Bound by UT, Connected for the Future',
      'description'   => 'Portal Alumni Universitas Terbuka untuk tracer study, pembaruan data alumni, pengembangan karier, dan jejaring alumni.',
      'button_text'   => 'Isi Tracer Study',
      'button_url'    => '/tracer',
      'image'         => 'images/banner1.png',
      'urutan'        => 1,
      'is_active'     => true,
      'publish_start' => Carbon::now(),
    ]);

    PortalHero::create([
      'badge'         => 'CAREER CENTER',
      'title'         => "Bangun Karier\nBersama Alumni UT",
      'subtitle'      => 'Career Growth Starts Here',
      'description'   => 'Temukan peluang kerja, pelatihan, dan pengembangan karier bersama jaringan Alumni Universitas Terbuka.',
      'button_text'   => 'Lihat Lowongan',
      'button_url'    => '/karir',
      'image'         => 'images/banner1.png',
      'urutan'        => 2,
      'is_active'     => false,
      'publish_start' => Carbon::now(),
    ]);

    PortalHero::create([
      'badge'         => 'SURVEY ALUMNI',
      'title'         => "Update Data\nAlumni UT",
      'subtitle'      => 'Stay Connected',
      'description'   => 'Perbarui data alumni Anda untuk memperoleh informasi kegiatan, layanan, dan kesempatan kolaborasi terbaru.',
      'button_text'   => 'Update Data',
      'button_url'    => '/alumni/update',
      'image'         => 'images/banner1.png',
      'urutan'        => 3,
      'is_active'     => false,
      'publish_start' => Carbon::now(),
    ]);
  }
}
