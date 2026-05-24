<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'level',
        'id_sessions',
    ];

    protected $hidden = ['password', 'remember_token'];

    public function canAccessPanel(Panel $panel): bool
    {
        return true; // semua user bisa login ke filament
    }

    public function isAdmin(): bool
    {
        return $this->level === 'admin';
    }

    public function isPetugas(): bool
    {
        return $this->level === 'petugas';
    }
}
