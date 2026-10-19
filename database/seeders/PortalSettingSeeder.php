<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PortalSettingSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    DB::table('portal_settings')->insert([
      'nama_portal' => 'Portal Alumni Universitas Terbuka',

      'slogan' => 'Bound by UT, Connected for the Future',

      'logo' => 'images/logo-ut.png',

      'hero_image' => 'images/banner1.png',

      'email' => 'alumni@ecampus.ut.ac.id',

      'telepon' => '1500024',

      'whatsapp' => '6285110556158',

      'instagram' => 'https://www.instagram.com/ut.alumnikarier',

      'facebook' => 'https://www.facebook.com/UnivTerbuka',

      'linkedin' => 'https://www.linkedin.com',

      'youtube' => 'https://www.youtube.com/@universitasterbukatv',

      'alamat' => 'Universitas Terbuka, Tangerang Selatan',

      'created_at' => now(),

      'updated_at' => now(),

    ]);
  }
}
