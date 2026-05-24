<?php

namespace Database\Factories;

use App\Models\Penimbangan;
use App\Models\Anak;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PenimbanganFactory extends Factory
{
    protected $model = Penimbangan::class;

    public function definition(): array
    {
        // Ambil anak random yang sudah ada
        $anak = Anak::inRandomOrder()->first();

        // Jika belum ada anak, buat dulu
        if (!$anak) {
            $anak = Anak::factory()->create();
        }

        // Hitung usia dalam bulan
        $usia = $anak->tgl_lahir->diffInMonths(now());

        // Tentukan status gizi random
        $statusOptions = ['Gizi Baik', 'Gizi Kurang', 'Gizi Lebih', 'Gizi Buruk'];
        $status = $this->faker->randomElement($statusOptions);

        // Berat badan berdasarkan status
        $berat = match ($status) {
            'Gizi Buruk' => $this->faker->randomFloat(1, 3.0, 5.5),
            'Gizi Kurang' => $this->faker->randomFloat(1, 5.5, 7.5),
            'Gizi Lebih' => $this->faker->randomFloat(1, 14.0, 18.0),
            default => $this->faker->randomFloat(1, 7.5, 12.0),
        };

        // Saran berdasarkan status
        $saran = match ($status) {
            'Gizi Buruk' => 'SEGERA konsultasikan ke petugas kesehatan. Anak membutuhkan penanganan intensif.',
            'Gizi Kurang' => 'Tingkatkan asupan makanan bergizi. Konsultasi ke petugas gizi.',
            'Gizi Lebih' => 'Batasi makanan manis dan berlemak. Perbanyak aktivitas fisik.',
            default => 'Pertahankan pola makan sehat. Lanjutkan pemberian ASI dan MPASI bergizi.',
        };

        return [
            'tgl_penimbangan' => $this->faker->dateTimeBetween('-6 months', 'now'), // <-- WAJIB DIISI
            'nik_anak' => $anak->nik_anak,
            'jenis_kelamin' => $anak->jenis_kelamin,
            'usia' => $usia, // <-- WAJIB DIISI
            'berat_badan' => $berat, // <-- WAJIB DIISI
            'keterangan' => $this->faker->randomElement(['naik', 'tetap', 'turun']), // <-- WAJIB DIISI
            'status_gizi' => $status, // <-- WAJIB DIISI
            'saran' => $saran,
        ];
    }
}
