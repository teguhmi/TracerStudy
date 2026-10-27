<?php

namespace Database\Seeders;

use App\Models\tracer\TracerKota;
use App\Models\tracer\TracerNegara;
use App\Models\tracer\TracerProvinsi;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

//      User::factory(10)->create();

      User::updateOrCreate(
        [
          'email' => 'teguhmi@gmail.com'
        ],
        [
          'name' => 'Test User',
          'password' => bcrypt('password'),
          'email_verified_at' => now(),
        ]
      );


      $this->call([
        TracerSectionSeeder::class,
        TracerPertanyaanSeeder::class,
        TracerOpsiSeeder::class,
        TracerPertanyaanUpdateSeeder::class,
        TracerSectionRuleSeeder::class,
        PortalLayananSeeder::class,
        PortalSettingSeeder::class,
        PortalHeroSeeder::class,
        TracerNegaraSeeder::class,
        TracerProvinsiSeeder::class,
        TracerKotaSeeder::class,
        M_NegaraSeeder::class,
        M_ProvinsiSeeder::class,
        M_KabupatenSeeder::class,
        TracerPeriodeSeeder::class,


      ]);

    }
}
