<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Anak;
use App\Models\Penimbangan;
use App\Models\Imunisasi;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class PosyanduSeeder extends Seeder
{
    public function run(): void
    {
        // ========== 1. BUAT USER ==========
        $users = [
            [
                'name' => 'Admin Posyandu',
                'email' => 'admin@posyandu.com',
                'password' => Hash::make('password123'),
                'level' => 'admin',
            ],
            [
                'name' => 'Petugas Lapangan',
                'email' => 'petugas@posyandu.com',
                'password' => Hash::make('password123'),
                'level' => 'petugas',
            ],
            [
                'name' => 'Kader Posyandu',
                'email' => 'kader@posyandu.com',
                'password' => Hash::make('password123'),
                'level' => 'kader',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                $user
            );
        }

        // ========== 2. BUAT DATA ANAK ==========
        $anakData = [
            // Anak dengan Gizi Baik
            [
                'nik_anak' => '1234567890123456',
                'no_kk' => '1111111111111111',
                'nama_anak' => 'Ahmad Wijaya',
                'nama_ayah' => 'Budi Wijaya',
                'nama_ibu' => 'Siti Wijaya',
                'anak_ke' => 1,
                'jenis_kelamin' => 'L',
                'tgl_lahir' => Carbon::createFromDate(2025, 1, 15),
                'bb_lahir' => 3200,
                'panjang_lahir' => 48,
                'alamat' => 'Jl. Mawar No. 1, RT 01/RW 01',
                'no_hp_ortu' => '081234567890',
            ],
            [
                'nik_anak' => '2234567890123456',
                'no_kk' => '1111111111111111',
                'nama_anak' => 'Siti Aisyah',
                'nama_ayah' => 'Budi Wijaya',
                'nama_ibu' => 'Siti Wijaya',
                'anak_ke' => 2,
                'jenis_kelamin' => 'P',
                'tgl_lahir' => Carbon::createFromDate(2026, 1, 10),
                'bb_lahir' => 3100,
                'panjang_lahir' => 47,
                'alamat' => 'Jl. Mawar No. 1, RT 01/RW 01',
                'no_hp_ortu' => '081234567890',
            ],
            // Anak dengan Gizi Kurang
            [
                'nik_anak' => '3234567890123456',
                'no_kk' => '2222222222222222',
                'nama_anak' => 'Bambang Susanto',
                'nama_ayah' => 'Susanto',
                'nama_ibu' => 'Sumarni',
                'anak_ke' => 1,
                'jenis_kelamin' => 'L',
                'tgl_lahir' => Carbon::createFromDate(2024, 8, 20),
                'bb_lahir' => 2500,
                'panjang_lahir' => 45,
                'alamat' => 'Jl. Melati No. 5, RT 02/RW 01',
                'no_hp_ortu' => '081234567891',
            ],
            [
                'nik_anak' => '4234567890123456',
                'no_kk' => '3333333333333333',
                'nama_anak' => 'Dewi Kartika',
                'nama_ayah' => 'Kartono',
                'nama_ibu' => 'Kartika',
                'anak_ke' => 3,
                'jenis_kelamin' => 'P',
                'tgl_lahir' => Carbon::createFromDate(2025, 5, 5),
                'bb_lahir' => 2800,
                'panjang_lahir' => 46,
                'alamat' => 'Jl. Kenanga No. 8, RT 03/RW 01',
                'no_hp_ortu' => '081234567892',
            ],
            // Anak dengan Gizi Lebih
            [
                'nik_anak' => '5234567890123456',
                'no_kk' => '4444444444444444',
                'nama_anak' => 'Cahya Pratama',
                'nama_ayah' => 'Pratama',
                'nama_ibu' => 'Cahya',
                'anak_ke' => 1,
                'jenis_kelamin' => 'L',
                'tgl_lahir' => Carbon::createFromDate(2025, 10, 12),
                'bb_lahir' => 3800,
                'panjang_lahir' => 50,
                'alamat' => 'Jl. Anggrek No. 12, RT 01/RW 02',
                'no_hp_ortu' => '081234567893',
            ],
            [
                'nik_anak' => '6234567890123456',
                'no_kk' => '5555555555555555',
                'nama_anak' => 'Nadia Putri',
                'nama_ayah' => 'Putra',
                'nama_ibu' => 'Putri',
                'anak_ke' => 2,
                'jenis_kelamin' => 'P',
                'tgl_lahir' => Carbon::createFromDate(2024, 12, 25),
                'bb_lahir' => 3600,
                'panjang_lahir' => 49,
                'alamat' => 'Jl. Dahlia No. 3, RT 02/RW 02',
                'no_hp_ortu' => '081234567894',
            ],
            // Anak dengan Gizi Buruk
            [
                'nik_anak' => '7234567890123456',
                'no_kk' => '6666666666666666',
                'nama_anak' => 'Eko Prasetyo',
                'nama_ayah' => 'Prasetyo',
                'nama_ibu' => 'Eka',
                'anak_ke' => 1,
                'jenis_kelamin' => 'L',
                'tgl_lahir' => Carbon::createFromDate(2025, 7, 18),
                'bb_lahir' => 2200,
                'panjang_lahir' => 44,
                'alamat' => 'Jl. Teratai No. 7, RT 03/RW 02',
                'no_hp_ortu' => '081234567895',
            ],
        ];

        foreach ($anakData as $data) {
            Anak::updateOrCreate(
                ['nik_anak' => $data['nik_anak']],
                $data
            );
        }

        // ========== 3. BUAT DATA PENIMBANGAN ==========

        // Ambil semua anak yang sudah dibuat
        $anakList = Anak::all();

        foreach ($anakList as $anak) {
            // Hitung usia dalam bulan
            $usiaBulan = $anak->tgl_lahir->diffInMonths(now());

            // Tentukan status gizi berdasarkan berat badan
            if ($anak->nik_anak === '3234567890123456') {
                // Bambang - Gizi Kurang
                $berat = 6.5;
                $status = 'Gizi Kurang';
                $saran = 'Tingkatkan asupan makanan bergizi. Konsultasi ke petugas gizi.';
                $keterangan = 'tetap';
            } elseif ($anak->nik_anak === '4234567890123456') {
                // Dewi - Gizi Kurang
                $berat = 7.2;
                $status = 'Gizi Kurang';
                $saran = 'Tingkatkan asupan makanan bergizi. Konsultasi ke petugas gizi.';
                $keterangan = 'turun';
            } elseif ($anak->nik_anak === '5234567890123456') {
                // Cahya - Gizi Lebih
                $berat = 14.5;
                $status = 'Gizi Lebih';
                $saran = 'Batasi makanan manis dan berlemak. Perbanyak aktivitas fisik.';
                $keterangan = 'naik';
            } elseif ($anak->nik_anak === '6234567890123456') {
                // Nadia - Gizi Lebih
                $berat = 15.0;
                $status = 'Gizi Lebih';
                $saran = 'Batasi makanan manis dan berlemak. Perbanyak aktivitas fisik.';
                $keterangan = 'tetap';
            } elseif ($anak->nik_anak === '7234567890123456') {
                // Eko - Gizi Buruk
                $berat = 5.2;
                $status = 'Gizi Buruk';
                $saran = 'SEGERA konsultasikan ke petugas kesehatan. Anak membutuhkan penanganan intensif.';
                $keterangan = 'turun';
            } else {
                // Ahmad, Siti, dll - Gizi Baik
                $berat = 8.5;
                $status = 'Gizi Baik';
                $saran = 'Pertahankan pola makan sehat. Lanjutkan pemberian ASI dan MPASI bergizi.';
                $keterangan = 'naik';
            }

            // Buat penimbangan terbaru
            Penimbangan::create([
                'tgl_penimbangan' => Carbon::now(),
                'nik_anak' => $anak->nik_anak,
                'jenis_kelamin' => $anak->jenis_kelamin,
                'usia' => $usiaBulan,
                'berat_badan' => $berat,
                'keterangan' => $keterangan,
                'status_gizi' => $status,
                'saran' => $saran,
            ]);

            // Buat penimbangan sebelumnya (riwayat)
            if ($anak->nik_anak !== '7234567890123456') {
                Penimbangan::create([
                    'tgl_penimbangan' => Carbon::now()->subMonth(),
                    'nik_anak' => $anak->nik_anak,
                    'jenis_kelamin' => $anak->jenis_kelamin,
                    'usia' => $usiaBulan - 1,
                    'berat_badan' => $berat - 0.5,
                    'keterangan' => 'naik',
                    'status_gizi' => $status,
                    'saran' => $saran,
                ]);
            }
        }

        // ========== 4. BUAT DATA IMUNISASI ==========
        $jenisImunisasi = ['BCG', 'DPT', 'Polio', 'Campak', 'Hepatitis B', 'Hib'];

        foreach ($anakList as $anak) {
            // Setiap anak punya 2-3 riwayat imunisasi
            $jumlahImunisasi = rand(2, 4);

            for ($i = 0; $i < $jumlahImunisasi; $i++) {
                $usiaImunisasi = $anak->tgl_lahir->diffInMonths(now()) - ($i * 2);
                if ($usiaImunisasi < 0) continue;

                Imunisasi::create([
                    'tgl_penimbangan' => Carbon::now()->subMonths($i * 2),
                    'nik_anak' => $anak->nik_anak,
                    'usia' => $usiaImunisasi,
                    'jenis_imunisasi' => $jenisImunisasi[array_rand($jenisImunisasi)],
                ]);
            }
        }

        $this->command->info('✅ Seeder Posyandu berhasil dijalankan!');
        $this->command->info('📊 Data yang dibuat:');
        $this->command->info('   - User: 3 akun (admin, petugas, kader)');
        $this->command->info('   - Anak: ' . Anak::count() . ' anak');
        $this->command->info('   - Penimbangan: ' . Penimbangan::count() . ' data');
        $this->command->info('   - Imunisasi: ' . Imunisasi::count() . ' data');
    }
}
