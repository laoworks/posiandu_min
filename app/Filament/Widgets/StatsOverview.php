<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Anak;
use App\Models\Penimbangan;
use App\Models\Imunisasi;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class StatsOverview extends BaseWidget
{
    // Opsional: Atur posisi widget (1 = paling atas)
    protected static ?int $sort = 1;

    // Opsional: Kolom yang digunakan (1-4)
    protected int | string | array $columnSpan = 'full';

    // Opsional: Hanya tampilkan di halaman dashboard
    protected function getColumns(): int
    {
        return 4; // 4 kolom statistik
    }

    protected function getStats(): array
    {
        $user = Auth::user();

        // Total data (berdasarkan role)
        if ($user->level === 'kader') {
            // Kader hanya melihat statistik dari anak yang menjadi tanggung jawabnya (jika ada filter wilayah)
            // Untuk default, kader tetap melihat semua statistik
            $totalAnak = Anak::count();
            $totalPenimbangan = Penimbangan::count();
            $totalImunisasi = Imunisasi::count();
            $totalPetugas = User::where('level', 'petugas')->count();
        } else {
            // Admin & Petugas melihat semua statistik
            $totalAnak = Anak::count();
            $totalPenimbangan = Penimbangan::count();
            $totalImunisasi = Imunisasi::count();
            $totalPetugas = User::where('level', 'petugas')->count();
        }

        // Statistik penimbangan bulan ini
        $penimbanganBulanIni = Penimbangan::whereMonth('tgl_penimbangan', Carbon::now()->month)
            ->whereYear('tgl_penimbangan', Carbon::now()->year)
            ->count();

        // Statistik status gizi
        $giziKurang = Penimbangan::where('status_gizi', 'Gizi Kurang')
            ->where('tgl_penimbangan', Penimbangan::max('tgl_penimbangan')) // data terbaru
            ->count();

        $giziBaik = Penimbangan::where('status_gizi', 'Gizi Baik')
            ->where('tgl_penimbangan', Penimbangan::max('tgl_penimbangan'))
            ->count();

        // Rata-rata berat badan anak
        $rataBeratBadan = Penimbangan::avg('berat_badan');

        // Anak dengan penimbangan terbaru (trend naik/turun)
        $trendNaik = Penimbangan::where('keterangan', 'naik')
            ->whereDate('tgl_penimbangan', Carbon::today())
            ->count();

        $trendTurun = Penimbangan::where('keterangan', 'turun')
            ->whereDate('tgl_penimbangan', Carbon::today())
            ->count();

        // Jadwal imunisasi hari ini
        $imunisasiHariIni = Imunisasi::whereDate('tgl_penimbangan', Carbon::today())->count();

        return [
            Stat::make('Total Anak Terdaftar', number_format($totalAnak, 0, ',', '.'))
                ->description('Jumlah seluruh anak di posyandu')
                ->descriptionIcon('heroicon-o-users')
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 8, 9]), // Opsional: chart mini

            Stat::make('Penimbangan Bulan Ini', number_format($penimbanganBulanIni, 0, ',', '.'))
                ->description('Dari total ' . number_format($totalPenimbangan, 0, ',', '.') . ' penimbangan')
                ->descriptionIcon('heroicon-o-calendar')
                ->color('info'),

            Stat::make('Status Gizi (Terbaru)', 'Baik: ' . $giziBaik . ' | Kurang: ' . $giziKurang)
                ->description($giziKurang > 0 ? $giziKurang . ' anak perlu perhatian khusus' : 'Semua anak gizi baik')
                ->descriptionIcon($giziKurang > 0 ? 'heroicon-o-exclamation-triangle' : 'heroicon-o-check-circle')
                ->color($giziKurang > 0 ? 'warning' : 'success'),

            Stat::make('Rata-rata Berat Badan', number_format($rataBeratBadan, 1, ',', '.') . ' kg')
                ->description('Standar WHO: 7-12 kg (0-12 bulan)')
                ->descriptionIcon('heroicon-o-scale')
                ->color('primary'),

            // Stat ke-5: Trending (opsional, bisa ditambahkan dengan mengubah getColumns() menjadi 5)
            // Stat::make('Trend Penimbangan Hari Ini', 'Naik: ' . $trendNaik . ' | Turun: ' . $trendTurun)
            //     ->description($trendTurun > 0 ? $trendTurun . ' anak mengalami penurunan berat badan' : 'Semua anak stabil')
            //     ->descriptionIcon('heroicon-o-arrow-trending-up')
            //     ->color($trendTurun > 0 ? 'danger' : 'success'),

            // Stat ke-6: Petugas (hanya untuk admin)
            ...($user->level === 'admin' ? [
                Stat::make('Petugas Aktif', number_format($totalPetugas, 0, ',', '.'))
                    ->description('Admin + Petugas + Kader')
                    ->descriptionIcon('heroicon-o-user-group')
                    ->color('gray')
            ] : []),
        ];
    }

    // Opsional: Hanya tampilkan untuk role tertentu
    public static function canView(): bool
    {
        // Semua user yang login bisa melihat widget
        return Auth::check();
    }
}
