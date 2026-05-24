<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Posyandu',
            'email' => 'admin@posyandu.com',
            'password' => Hash::make('password123'),
            'level' => 'admin',
        ]);

        User::create([
            'name' => 'Petugas Lapangan',
            'email' => 'petugas@posyandu.com',
            'password' => Hash::make('password123'),
            'level' => 'petugas',
        ]);

        User::create([
            'name' => 'Kader Posyandu',
            'email' => 'kader@posyandu.com',
            'password' => Hash::make('password123'),
            'level' => 'kader',
        ]);
    }
}
