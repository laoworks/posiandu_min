<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Setting;
use Illuminate\Support\Facades\View;

class SettingServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Share settings ke semua view
        View::composer('*', function ($view) {
            $settings = [
                'website_name' => Setting::get('website_name', 'SIPOSYANDA'),
                'website_subtitle' => Setting::get('website_subtitle', 'Desa Buano Utara'),
                'website_fullname' => Setting::get('website_fullname', 'Sistem Informasi Posyandu'),
                'logo_path' => Setting::get('logo_path', '/images/default-logo.png'),
                'favicon_path' => Setting::get('favicon_path', '/images/default-favicon.ico'),
            ];
            $view->with('settings', $settings);
        });
    }

    public function register(): void
    {
        //
    }
}
