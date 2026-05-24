<?php

namespace App\Providers\Filament;

use App\Models\Setting;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        // Website Name
        $websiteName = Setting::get('website_name', 'SIPOSYANDA');

        // Logo & Favicon Path
        $logoPath = Setting::get('logo_path', '');
        $faviconPath = Setting::get('favicon_path', '');

        /*
        |--------------------------------------------------------------------------
        | Logo URL
        |--------------------------------------------------------------------------
        */

        $logoUrl = null;

        if (!empty($logoPath)) {

            // Jika path storage
            if (str_starts_with($logoPath, '/storage/')) {

                $logoUrl = asset($logoPath);
            }

            // Jika file ada di public
            elseif (file_exists(public_path($logoPath))) {

                $logoUrl = asset($logoPath);
            }

            // Jika file ada di storage/app/public
            elseif (Storage::disk('public')->exists($logoPath)) {

                $logoUrl = Storage::url($logoPath);
            }

            // Jika hanya nama file
            elseif (file_exists(public_path('images/logo/' . $logoPath))) {

                $logoUrl = asset('images/logo/' . $logoPath);
            }
        }

        // Default logo
        if (!$logoUrl && file_exists(public_path('images/logo/siposyanda.png'))) {

            $logoUrl = asset('images/logo/siposyanda.png');
        }

        /*
        |--------------------------------------------------------------------------
        | Favicon URL
        |--------------------------------------------------------------------------
        */

        $faviconUrl = null;

        if (!empty($faviconPath)) {

            if (str_starts_with($faviconPath, '/storage/')) {

                $faviconUrl = asset($faviconPath);
            } elseif (file_exists(public_path($faviconPath))) {

                $faviconUrl = asset($faviconPath);
            } elseif (Storage::disk('public')->exists($faviconPath)) {

                $faviconUrl = Storage::url($faviconPath);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Filament Panel
        |--------------------------------------------------------------------------
        */

        return $panel
            ->default()
            ->id('admin')
            ->path('admin')

            // Auth
            ->login()
            ->profile()

            // Theme
            ->colors([
                'primary' => Color::Green,
            ])

            // Branding
            ->brandName($websiteName)
            ->brandLogo($logoUrl)
            ->brandLogoHeight('2rem')
            ->favicon($faviconUrl)

            // Resources
            ->discoverResources(
                in: app_path('Filament/Resources'),
                for: 'App\\Filament\\Resources'
            )

            // Pages
            ->discoverPages(
                in: app_path('Filament/Pages'),
                for: 'App\\Filament\\Pages'
            )

            ->pages([
                Pages\Dashboard::class,
            ])

            // Widgets
            ->discoverWidgets(
                in: app_path('Filament/Widgets'),
                for: 'App\\Filament\\Widgets'
            )

            ->widgets([
                Widgets\AccountWidget::class,
                \App\Filament\Widgets\StatsOverview::class,
            ])

            // Middleware
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])

            // Auth Middleware
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
