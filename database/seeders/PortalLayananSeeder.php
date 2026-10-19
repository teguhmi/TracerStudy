<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PortalLayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      DB::table('portal_layanans')->insert([
        [
          'nama' => 'Profil Alumni',
          'slug' => 'profil-alumni',
          'icon' => 'fa-user',
          'warna' => 'blue',
          'deskripsi' => 'Kelola profil dan data alumni.',
          'url' => 'https://myut-alumni.ut.ac.id',
          'class' => null,
          'text' => null,
          'is_external' => true,
          'urutan' => 1,
          'aktif' => true,
        ],
        [
          'nama' => 'Tracer Study',
          'slug' => 'tracer-study',
          'icon' => 'fa-chart-line',
          'warna' => 'yellow',
          'deskripsi' => 'Berpartisipasi dalam tracer study Alumni UT.',
          'url' => '/tracer',
          'class' => null,
          'text' => null,
          'is_external' => false,
          'urutan' => 2,
          'aktif' => true,
        ],
        [
          'nama' => 'Pusat Karier',
          'slug' => 'pusat-karier',
          'icon' => 'fa-briefcase',
          'warna' => 'green',
          'deskripsi' => 'Informasi lowongan kerja dan pengembangan karier.',
          'url' => 'https://pusatkarier.ut.ac.id',
          'class' => null,
          'text' => null,
          'is_external' => true,
          'urutan' => 3,
          'aktif' => true,
        ],
        [
          'nama' => 'Komunitas Alumni',
          'slug' => 'komunitas-alumni',
          'icon' => 'fa-users',
          'warna' => 'purple',
          'deskripsi' => 'Terhubung dengan alumni UT dari seluruh Indonesia dan dunia.',
          'url' => '#',
          'class' => null,
          'text' => null,
          'is_external' => false,
          'urutan' => 4,
          'aktif' => true,
        ],

        [
          'nama' => 'Surat Keterangan & Legalisir',
          'slug' => 'surat-keterangan-legalisir',
          'icon' => 'fa-certificate',
          'warna' => 'orange',
          'deskripsi' => 'Pengajuan surat keterangan, legalisir ijazah, dan layanan akademik.',
          'url' => 'https://aksi.ut.ac.id',
          'class' => null,
          'text' => null,
          'is_external' => true,
          'urutan' => 5,
          'aktif' => true,
        ],

        [
          'nama' => 'Dana Abadi Alumni',
          'slug' => 'dana-abadi-alumni',
          'icon' => 'fa-heart',
          'warna' => 'pink',
          'deskripsi' => 'Bersama alumni membangun masa depan Universitas Terbuka melalui Dana Abadi.',
          'url' => 'https://www.instagram.com/reel/DZrGfJRJqTC/',
          'class'=> 'group bg-gradient-to-br from-red-500 to-pink-500 text-white rounded-3xl p-8 shadow-xl hover:shadow-2xl hover:-translate-y-2 transition-all duration-300',
          'text'=>'text-white/90 text-sm',
          'is_external' => true,
          'urutan' => 6,
          'aktif' => true,
        ],
      ]);
    }
}
