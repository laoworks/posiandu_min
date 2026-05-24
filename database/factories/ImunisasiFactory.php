<?php

namespace Database\Factories;

use App\Models\Imunisasi;
use App\Models\Anak;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ImunisasiFactory extends Factory
{
    protected $model = Imunisasi::class;

    public function definition(): array
    {
        // Ambil anak random yang sudah ada
        $anak = Anak::inRandomOrder()->first();

        // Jika belum ada anak, buat dulu
        if (!$anak) {
            $anak = Anak::factory()->create();
        }

        $jenisImunisasi = ['BCG', 'DPT', 'Polio', 'Campak', 'Hepatitis B', 'Hib', 'Rotavirus', 'PCV'];

        return [
            'tgl_penimbangan' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'nik_anak' => $anak->nik_anak,
            'usia' => $anak->tgl_lahir->diffInMonths(now()),
            'jenis_imunisasi' => $this->faker->randomElement($jenisImunisasi),
        ];
    }
}
