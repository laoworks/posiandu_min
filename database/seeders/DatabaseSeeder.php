<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Anak;
use App\Models\Penimbangan;
use App\Models\Imunisasi;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(UserSeeder::class);

        // Buat 20 data anak dummy
        Anak::factory(20)->create()->each(function ($anak) {
            // Setiap anak punya 3-5 riwayat penimbangan
            Penimbangan::factory(rand(3, 5))->create([
                'nik_anak' => $anak->nik_anak,
                'jenis_kelamin' => $anak->jenis_kelamin,
            ]);

            // Setiap anak punya 2-4 riwayat imunisasi
            Imunisasi::factory(rand(2, 4))->create([
                'nik_anak' => $anak->nik_anak,
            ]);
        });

        $this->call([
            PosyanduSeeder::class,
        ]);
    }
}
