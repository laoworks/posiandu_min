<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

// Halaman home (tanpa login)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Route login (default Laravel/Filament)
Route::get('/login', function () {
    return redirect('/admin/login');
})->name('login');

// Filament akan handle sisanya
