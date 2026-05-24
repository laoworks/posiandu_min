<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::set('website_name', 'SIPOSYANDA');
        Setting::set('website_subtitle', 'Desa Buano Utara');
        Setting::set('website_fullname', 'Rancang Bangun Sistem Informasi Posyandu Balita Berbasis Website');
        Setting::set('logo_path', '/images/default-logo.png');
        Setting::set('favicon_path', '/images/default-favicon.ico');
    }
}
