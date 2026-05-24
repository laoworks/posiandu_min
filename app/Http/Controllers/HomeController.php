<?php

namespace App\Http\Controllers;

use App\Models\Anak;
use App\Models\Penimbangan;
use App\Models\Imunisasi;
use App\Models\User;
use App\Models\Setting;

class HomeController extends Controller
{
    public function index()
    {
        $totalAnak = Anak::count();
        $totalPenimbangan = Penimbangan::count();
        $totalImunisasi = Imunisasi::count();
        $totalPetugas = User::where('level', 'petugas')->count();
        $anakTerbaru = Anak::orderBy('created_at', 'desc')->limit(5)->get();

        // Ambil pengaturan website
        $settings = [
            'website_name' => Setting::get('website_name', 'SIPOSYANDA'),
            'website_subtitle' => Setting::get('website_subtitle', 'Desa Buano Utara'),
            'website_fullname' => Setting::get('website_fullname', 'Sistem Informasi Posyandu Balita'),
            'logo_path' => Setting::get('logo_path', '/images/default-logo.png'),
            'favicon_path' => Setting::get('favicon_path', '/images/default-favicon.ico'),
        ];

        return view('home', compact('totalAnak', 'totalPenimbangan', 'totalImunisasi', 'totalPetugas', 'anakTerbaru', 'settings'));
    }
}
