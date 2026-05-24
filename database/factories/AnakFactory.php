<?php

namespace Database\Factories;

use App\Models\Anak;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnakFactory extends Factory
{
    protected $model = Anak::class;

    public function definition(): array
    {
        $jk = $this->faker->randomElement(['L', 'P']);

        return [
            'nik_anak' => $this->faker->unique()->numerify('################'),
            'no_kk' => $this->faker->numerify('################'),
            'nama_anak' => $this->faker->firstName($jk === 'L' ? 'male' : 'female'),
            'nama_ayah' => $this->faker->firstNameMale(),
            'nama_ibu' => $this->faker->firstNameFemale(),
            'anak_ke' => $this->faker->numberBetween(1, 5),
            'jenis_kelamin' => $jk,
            'tgl_lahir' => $this->faker->dateTimeBetween('-3 years', 'now'),
            'bb_lahir' => $this->faker->numberBetween(2500, 4000),
            'panjang_lahir' => $this->faker->numberBetween(45, 55),
            'alamat' => $this->faker->address(),
            // Perbaiki: Buat nomor telepon dengan panjang maksimal 15 karakter
            'no_hp_ortu' => $this->faker->numerify('08##########'), // Format: 08xxxxxxxxxx (max 13 char)
        ];
    }
}
