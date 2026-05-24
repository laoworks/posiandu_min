<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>{{ $settings['website_fullname'] }} - {{ $settings['website_subtitle'] }}</title>

    @php
        $faviconUrl = null;
        $logoUrl = null;

        if (!empty($settings['favicon_path'])) {
            if (str_starts_with($settings['favicon_path'], '/storage/')) {
                $faviconUrl = asset($settings['favicon_path']);
            } elseif (file_exists(public_path($settings['favicon_path']))) {
                $faviconUrl = asset($settings['favicon_path']);
            } elseif (\Illuminate\Support\Facades\Storage::disk('public')->exists($settings['favicon_path'])) {
                $faviconUrl = \Illuminate\Support\Facades\Storage::url($settings['favicon_path']);
            }
        }

        if (!empty($settings['logo_path'])) {
            if (str_starts_with($settings['logo_path'], '/storage/')) {
                $logoUrl = asset($settings['logo_path']);
            } elseif (file_exists(public_path($settings['logo_path']))) {
                $logoUrl = asset($settings['logo_path']);
            } elseif (\Illuminate\Support\Facades\Storage::disk('public')->exists($settings['logo_path'])) {
                $logoUrl = \Illuminate\Support\Facades\Storage::url($settings['logo_path']);
            }
        }
    @endphp

    @if($faviconUrl)
        <link rel="icon" href="{{ $faviconUrl }}">
    @endif

    <!-- Google Fonts + Tailwind + Font Awesome -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <style>
        * {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        html {
            scroll-behavior: smooth;
        }
        body {
            font-family: 'Inter', sans-serif;
        }

        /* custom container variables to match design tokens */
        .max-w-container-max {
            max-width: 1280px;
        }
        .px-gutter {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }
        @media (min-width: 768px) {
            .px-gutter {
                padding-left: 2rem;
                padding-right: 2rem;
            }
        }
        @media (min-width: 1024px) {
            .px-gutter {
                padding-left: 2.5rem;
                padding-right: 2.5rem;
            }
        }
        .text-display {
            font-size: 3rem;
            font-weight: 800;
            line-height: 1.2;
        }
        @media (min-width: 768px) {
            .text-display {
                font-size: 3.5rem;
            }
        }
        @media (min-width: 1024px) {
            .text-display {
                font-size: 4rem;
            }
        }
        .text-body-lg {
            font-size: 1.125rem;
            line-height: 1.6;
        }
        .text-label-sm {
            font-size: 0.75rem;
            font-weight: 500;
            letter-spacing: 0.02em;
        }
        .text-label-md {
            font-size: 0.875rem;
            font-weight: 600;
            letter-spacing: 0.01em;
        }
        .text-headline-md {
            font-size: 1.5rem;
            font-weight: 700;
        }
        .font-display {
            font-weight: 800;
        }
        .font-body-lg {
            font-weight: 400;
        }
        .font-label-sm {
            font-weight: 500;
        }
        .font-label-md {
            font-weight: 600;
        }
        .font-headline-md {
            font-weight: 700;
        }

        /* Background color utilities (matching design tokens) */
        .bg-secondary-container\/20 {
            background-color: rgba(68, 187, 140, 0.2);
        }
        .bg-primary-fixed\/20 {
            background-color: rgba(0, 105, 72, 0.2);
        }
        .bg-primary-fixed\/30 {
            background-color: rgba(0, 105, 72, 0.3);
        }
        .text-on-primary-fixed-variant {
            color: #0a4c3e;
        }
        .text-primary {
            color: #006948;
        }
        .text-on-surface {
            color: #0f172a;
        }
        .text-on-surface-variant {
            color: #475569;
        }
        .bg-secondary-container {
            background-color: #d1fae5;
        }
        .text-secondary {
            color: #0b5e4b;
        }
        .bg-primary-fixed {
            background-color: #e6f7ef;
        }

        /* Custom floating animations */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        .floating {
            animation: float 4s ease-in-out infinite;
        }
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(25px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-up {
            opacity: 0;
            animation: fadeUp 0.7s ease forwards;
        }
        .delay-100 {
            animation-delay: 0.2s;
        }
        .delay-200 {
            animation-delay: 0.4s;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }
        .primary-gradient {
            background: linear-gradient(135deg, #006948 0%, #00875a 100%);
        }

        /* Responsive adjustments */
        @media (max-width: 1023px) {
            .relative.h-\[500px\] {
                height: 420px;
            }
        }
        @media (max-width: 640px) {
            .relative.h-\[500px\] {
                height: 380px;
            }
            .absolute.-top-10.-right-8 {
                top: -0.5rem;
                right: -0.5rem;
                width: 10rem;
            }
            .absolute.bottom-10.-left-12 {
                bottom: 1rem;
                left: -1rem;
                width: 12rem;
            }
        }
    </style>
</head>
<body class="bg-white text-gray-800 antialiased">

    <!-- ==================== NAVBAR (Ringan & Modern) ==================== -->
    <nav class="sticky top-0 z-50 bg-white/85 backdrop-blur-md border-b border-gray-100 shadow-sm transition-all duration-300">
        <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-10">
            <div class="flex items-center justify-between h-16 md:h-18">

                <!-- Logo + branding -->
                <div class="flex items-center gap-3 flex-shrink-0">
                    @if($logoUrl)
                        <img src="{{ $logoUrl }}"
                             alt="Logo Posyandu"
                             class="h-10 w-10 md:h-11 md:w-11 object-contain rounded-xl bg-gradient-to-br from-green-50 to-emerald-50 p-1.5 shadow-sm">
                    @else
                        <div class="h-10 w-10 md:h-11 md:w-11 rounded-xl bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center shadow-sm">
                            <i class="fas fa-hand-holding-heart text-green-700 text-lg"></i>
                        </div>
                    @endif
                    <div class="leading-tight">
                        <h1 class="text-gray-800 font-bold text-base md:text-lg tracking-tight">
                            {{ $settings['website_name'] }}
                        </h1>
                        <p class="text-gray-500 text-[11px] md:text-xs font-medium">
                            {{ $settings['website_subtitle'] }}
                        </p>
                    </div>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center gap-2 lg:gap-3">
                    <a href="#fitur" class="text-gray-600 hover:text-green-700 px-3 py-2 text-sm font-medium transition-all duration-200 rounded-xl hover:bg-green-50">Fitur</a>
                    <a href="#tentang" class="text-gray-600 hover:text-green-700 px-3 py-2 text-sm font-medium transition-all duration-200 rounded-xl hover:bg-green-50">Tentang</a>
                    @auth
                        <a href="{{ url('/admin') }}" class="ml-2 inline-flex items-center gap-2 bg-green-700 hover:bg-green-800 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition shadow-md hover:shadow-lg">
                            <i class="fas fa-chart-pie text-sm"></i> Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="ml-2 inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition shadow-md hover:shadow-lg">
                            <i class="fas fa-sign-in-alt text-sm"></i> Masuk
                        </a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <button id="mobileMenuButton" class="md:hidden w-10 h-10 rounded-xl bg-gray-100 text-green-700 flex items-center justify-center hover:bg-green-50 transition">
                    <i class="fas fa-bars text-lg"></i>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div id="mobileMenu" class="hidden md:hidden pb-5 px-2 border-t border-gray-100 mt-2">
                <div class="flex flex-col gap-2 pt-4">
                    <a href="#fitur" class="text-gray-700 hover:bg-green-50 px-4 py-3 rounded-xl font-medium transition">Fitur</a>
                    <a href="#tentang" class="text-gray-700 hover:bg-green-50 px-4 py-3 rounded-xl font-medium transition">Tentang</a>
                    @auth
                        <a href="{{ url('/admin') }}" class="bg-green-50 text-green-800 px-4 py-3 rounded-xl font-semibold inline-flex items-center gap-2 mt-1">
                            <i class="fas fa-chart-pie"></i> Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="bg-green-600 text-white px-4 py-3 rounded-xl font-semibold inline-flex items-center gap-2 mt-1 justify-center">
                            <i class="fas fa-sign-in-alt"></i> Masuk
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- ==================== HERO SECTION (DESAIN BARU SESUAI PERMINTAAN) ==================== -->
    <section class="relative pt-32 pb-20 overflow-hidden bg-white">
        <!-- Background Orbs -->
        <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/4 w-[600px] h-[600px] bg-secondary-container/20 rounded-full blur-[120px] -z-10"></div>
        <div class="absolute bottom-0 left-0 translate-y-1/2 -translate-x-1/4 w-[500px] h-[500px] bg-primary-fixed/20 rounded-full blur-[100px] -z-10"></div>

        <div class="max-w-container-max mx-auto px-gutter grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Kiri: Teks Hero -->
            <div class="animate-fade-up">
                <span class="inline-block px-4 py-1 rounded-full bg-primary-fixed/30 text-on-primary-fixed-variant font-label-sm text-label-sm mb-6">
                    Inovasi Kesehatan Masa Depan
                </span>
                <h1 class="font-display text-display text-on-surface mb-6 leading-tight">
                    Digitalisasi Posyandu untuk <span class="text-primary">Indonesia Sehat</span>
                </h1>
                <p class="font-body-lg text-body-lg text-on-surface-variant mb-10 max-w-lg">
                    Transformasi layanan kesehatan masyarakat melalui sistem terintegrasi yang memudahkan pemantauan tumbuh kembang anak secara akurat dan real-time.
                </p>
                <div class="flex flex-wrap gap-4">
                    @auth
                        <a href="{{ url('/admin') }}" class="primary-gradient text-white px-8 py-4 rounded-full font-label-md text-label-md flex items-center gap-2 hover:scale-105 transition-transform shadow-lg group">
                            Dashboard
                            <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="primary-gradient text-white px-8 py-4 rounded-full font-label-md text-label-md flex items-center gap-2 hover:scale-105 transition-transform shadow-lg group">
                            Mulai Sekarang
                            <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
                        </a>
                    @endauth
                    <a href="#fitur" class="bg-white/40 backdrop-blur-md border border-white/60 text-primary px-8 py-4 rounded-full font-label-md text-label-md hover:bg-white/60 transition-all">
                        Pelajari Fitur
                    </a>
                </div>
            </div>

            <!-- Kanan: Visual Interaktif + Floating Cards -->
            <div class="relative h-[500px] animate-fade-up delay-100 flex items-center justify-center">
                <!-- Main Visual Card (floating image) -->
                <div class="relative w-full max-w-md aspect-square rounded-3xl overflow-hidden shadow-2xl z-10 floating">
                    <img
                        alt="Health UI - tablet showing posyandu growth metrics, modern clinic environment"
                        class="w-full h-full object-cover"
                        src="https://images.unsplash.com/photo-1576091160550-2173dba999ef?q=80&w=2070&auto=format&fit=crop"
                        onerror="this.src='https://placehold.co/600x600/e6f7ef/006948?text=Posyandu+Digital'"
                    >
                </div>

                <!-- Floating Glass Card Kanan Atas -->
                <div class="absolute -top-10 -right-8 w-48 glass-card rounded-3xl p-4 z-20 floating" style="animation-delay: 1s">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 rounded-full bg-secondary-container flex items-center justify-center">
                            <span class="material-symbols-outlined text-secondary">trending_up</span>
                        </div>
                        <div class="text-label-sm font-label-sm text-on-surface-variant">Pertumbuhan</div>
                    </div>
                    <div class="text-headline-md font-headline-md text-primary">+12.5%</div>
                </div>

                <!-- Floating Glass Card Kiri Bawah -->
                <div class="absolute bottom-10 -left-12 w-56 glass-card rounded-3xl p-4 z-20 floating" style="animation-delay: 2s">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-full bg-primary-fixed flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary">groups</span>
                        </div>
                        <div class="text-label-sm font-label-sm text-on-surface-variant">Pasien Aktif</div>
                    </div>
                    <div class="flex -space-x-2">
                        <div class="w-8 h-8 rounded-full border-2 border-white bg-slate-200"></div>
                        <div class="w-8 h-8 rounded-full border-2 border-white bg-slate-300"></div>
                        <div class="w-8 h-8 rounded-full border-2 border-white bg-slate-400"></div>
                        <div class="w-8 h-8 rounded-full border-2 border-white bg-primary text-[10px] text-white flex items-center justify-center font-bold">+50</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== FITUR SECTION ==================== -->
    <section id="fitur" class="py-20 md:py-28 bg-white relative">
        <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-12">
            <div class="text-center max-w-2xl mx-auto mb-14 animate-fade-up">
                <span class="text-green-600 font-semibold text-sm uppercase tracking-wider bg-green-50 px-4 py-1.5 rounded-full">Keunggulan Sistem</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mt-4">Fitur Modern untuk Posyandu</h2>
                <p class="text-gray-500 mt-4 text-lg">Solusi lengkap pengelolaan data kesehatan balita yang mudah, cepat, dan akurat.</p>
            </div>

            @php
                $features = [
                    ['icon' => 'fa-baby', 'title' => 'Data Balita', 'desc' => 'Kelola identitas, riwayat kesehatan, dan perkembangan balita dengan rapi.', 'color' => 'green'],
                    ['icon' => 'fa-weight-scale', 'title' => 'Monitoring Berat Badan', 'desc' => 'Pantau pertumbuhan balita dengan grafik dan status gizi realtime.', 'color' => 'blue'],
                    ['icon' => 'fa-syringe', 'title' => 'Jadwal Imunisasi', 'desc' => 'Notifikasi jadwal imunisasi otomatis serta riwayat lengkap.', 'color' => 'purple'],
                    ['icon' => 'fa-chart-line', 'title' => 'Dashboard Analitik', 'desc' => 'Visualisasi data statistik dan laporan perkembangan posyandu.', 'color' => 'orange'],
                    ['icon' => 'fa-download', 'title' => 'Ekspor Laporan', 'desc' => 'Export data ke Excel, CSV, dan PDF untuk administrasi dan arsip.', 'color' => 'red'],
                    ['icon' => 'fa-users-gear', 'title' => 'Multi Role User', 'desc' => 'Akses khusus untuk admin, kader, bidan desa, dan pemangku kepentingan.', 'color' => 'teal'],
                ];
            @endphp

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-7 md:gap-8">
                @foreach($features as $index => $feature)
                    @php
                        $bgIcon = match($feature['color']) {
                            'green' => 'bg-green-50 text-green-600',
                            'blue' => 'bg-blue-50 text-blue-600',
                            'purple' => 'bg-purple-50 text-purple-600',
                            'orange' => 'bg-orange-50 text-orange-600',
                            'red' => 'bg-red-50 text-red-600',
                            default => 'bg-teal-50 text-teal-600',
                        };
                    @endphp
                    <div class="group bg-white rounded-2xl p-7 border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 animate-fade-up" style="animation-delay: {{ $index * 0.05 }}s">
                        <div class="w-14 h-14 rounded-2xl {{ $bgIcon }} flex items-center justify-center mb-5 transition group-hover:scale-105 duration-200">
                            <i class="fas {{ $feature['icon'] }} text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $feature['title'] }}</h3>
                        <p class="text-gray-500 leading-relaxed">{{ $feature['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ==================== TENTANG + KEUNGGULAN ==================== -->
    <section id="tentang" class="py-20 bg-gradient-to-br from-gray-50 to-white">
        <div class="max-w-6xl mx-auto px-6 sm:px-10 lg:px-12">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="order-2 lg:order-1 animate-fade-up">
                    <div class="relative">
                        <div class="absolute -top-6 -left-6 w-32 h-32 bg-green-100 rounded-full opacity-40 blur-2xl"></div>
                        <div class="relative bg-white rounded-3xl p-6 shadow-xl border border-gray-100">
                            <i class="fas fa-quote-left text-green-600 text-3xl opacity-40 mb-3"></i>
                            <p class="text-gray-600 text-lg italic leading-relaxed">"Sistem ini membantu kader posyandu mencatat data balita dengan lebih mudah, cepat, dan akurat. Seluruh data tersimpan rapi dan dapat diakses kapan saja."</p>
                            <div class="flex items-center gap-3 mt-6 pt-2 border-t border-gray-100">
                                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                                    <i class="fas fa-hand-holding-heart text-green-700"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Tim Posyandu Digital</p>
                                    <p class="text-xs text-gray-500">Pelayanan Prima untuk Balita Sehat</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="order-1 lg:order-2 space-y-5 animate-fade-up delay-100">
                    <span class="text-green-700 font-semibold text-sm bg-green-100 px-4 py-1.5 rounded-full">Tentang Kami</span>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 leading-tight">{{ $settings['website_name'] }} <span class="text-green-700">Inovasi Posyandu</span></h2>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        {{ $settings['website_fullname'] }} dikembangkan untuk mendigitalisasi layanan posyandu, meningkatkan efisiensi pencatatan,
                        memudahkan monitoring kesehatan balita, serta mendorong transparansi data antar kader dan dinas kesehatan.
                    </p>
                    <div class="flex flex-wrap gap-5 pt-3">
                        <div class="flex items-center gap-2"><i class="fas fa-check-circle text-green-600"></i><span class="text-gray-700">Akses Real-time</span></div>
                        <div class="flex items-center gap-2"><i class="fas fa-check-circle text-green-600"></i><span class="text-gray-700">Laporan Otomatis</span></div>
                        <div class="flex items-center gap-2"><i class="fas fa-check-circle text-green-600"></i><span class="text-gray-700">Berkelanjutan & Gratis</span></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA BANNER -->
    <div class="bg-gradient-to-r from-green-700 to-emerald-800 py-14 md:py-16">
        <div class="max-w-5xl mx-auto text-center px-6">
            <h3 class="text-2xl md:text-3xl font-bold text-white">Siap Mengelola Posyandu Lebih Modern?</h3>
            <p class="text-green-100 mt-3 mb-8 text-lg">Bergabunglah bersama ratusan kader dan tenaga kesehatan yang menggunakan platform ini.</p>
            @auth
                <a href="{{ url('/admin') }}" class="inline-flex items-center gap-2 bg-white text-green-700 px-8 py-4 rounded-2xl font-bold text-lg shadow-xl hover:bg-gray-50 transition transform hover:scale-105">
                    <i class="fas fa-chart-line"></i> Kunjungi Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 bg-white text-green-700 px-8 py-4 rounded-2xl font-bold text-lg shadow-xl hover:bg-gray-50 transition transform hover:scale-105">
                    <i class="fas fa-user-plus"></i> Mulai Sekarang
                </a>
            @endauth
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="bg-gray-900 text-gray-300 pt-12 pb-8">
        <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 border-b border-gray-800 pb-8">
                <div>
                    <div class="flex items-center gap-2">
                        @if($logoUrl)
                            <img src="{{ $logoUrl }}" class="h-9 w-9 rounded-lg bg-white/10 p-1" alt="Logo">
                        @else
                            <i class="fas fa-heartbeat text-green-400 text-2xl"></i>
                        @endif
                        <span class="font-bold text-white text-lg">{{ $settings['website_name'] }}</span>
                    </div>
                    <p class="text-sm text-gray-400 mt-3 leading-relaxed">Sistem Informasi Posyandu Digital, memudahkan pemantauan tumbuh kembang balita dan efisiensi kerja kader posyandu.</p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-3">Tautan Penting</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#fitur" class="text-gray-400 hover:text-green-300 transition">Fitur Layanan</a></li>
                        <li><a href="#tentang" class="text-gray-400 hover:text-green-300 transition">Tentang Kami</a></li>
                        @auth
                            <li><a href="{{ url('/admin') }}" class="text-gray-400 hover:text-green-300 transition">Area Admin</a></li>
                        @else
                            <li><a href="{{ route('login') }}" class="text-gray-400 hover:text-green-300 transition">Login Petugas</a></li>
                        @endauth
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-3">Kontak & Dukungan</h4>
                    <p class="text-sm text-gray-400"><i class="fas fa-envelope mr-2"></i> posyandu@digital.id</p>
                    <p class="text-sm text-gray-400 mt-2"><i class="fas fa-phone-alt mr-2"></i> (021) 1234-5678</p>
                    <div class="flex gap-4 mt-4">
                        <i class="fab fa-instagram text-gray-500 hover:text-green-300 cursor-pointer transition"></i>
                        <i class="fab fa-facebook text-gray-500 hover:text-green-300 cursor-pointer transition"></i>
                        <i class="fab fa-youtube text-gray-500 hover:text-green-300 cursor-pointer transition"></i>
                    </div>
                </div>
            </div>
            <div class="flex flex-col md:flex-row justify-between items-center pt-6 text-sm text-gray-500">
                <p>&copy; {{ date('Y') }} {{ $settings['website_name'] }}. All rights reserved.</p>
                <p class="mt-2 md:mt-0">Membangun generasi sehat bersama Posyandu Digital</p>
            </div>
        </div>
    </footer>

    <!-- Mobile Menu Toggle JS -->
    <script>
        (function(){
            const mobileBtn = document.getElementById('mobileMenuButton');
            const mobilePanel = document.getElementById('mobileMenu');
            if(mobileBtn && mobilePanel) {
                mobileBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    mobilePanel.classList.toggle('hidden');
                    const icon = mobileBtn.querySelector('i');
                    if(mobilePanel.classList.contains('hidden')) {
                        icon.classList.remove('fa-times');
                        icon.classList.add('fa-bars');
                    } else {
                        icon.classList.remove('fa-bars');
                        icon.classList.add('fa-times');
                    }
                });
                const mobileLinks = mobilePanel.querySelectorAll('a');
                mobileLinks.forEach(link => {
                    link.addEventListener('click', () => {
                        mobilePanel.classList.add('hidden');
                        const icon = mobileBtn.querySelector('i');
                        icon.classList.remove('fa-times');
                        icon.classList.add('fa-bars');
                    });
                });
            }
        })();
    </script>
</body>
</html>
