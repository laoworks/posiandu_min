<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // <-- TAMBAHKAN INI

class Anak extends Model
{
    use HasFactory; // <-- TAMBAHKAN INI

    protected $table = 'anak';
    protected $primaryKey = 'nik_anak';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nik_anak',
        'no_kk',
        'nama_anak',
        'nama_ayah',
        'nama_ibu',
        'anak_ke',
        'jenis_kelamin',
        'tgl_lahir',
        'bb_lahir',
        'panjang_lahir',
        'alamat',
        'no_hp_ortu'
    ];

    protected $casts = [
        'tgl_lahir' => 'date',
        'jenis_kelamin' => 'string',
    ];

    public function penimbangan()
    {
        return $this->hasMany(Penimbangan::class, 'nik_anak', 'nik_anak');
    }

    public function imunisasi()
    {
        return $this->hasMany(Imunisasi::class, 'nik_anak', 'nik_anak');
    }

    public function getUsiaSekarangAttribute()
    {
        return $this->tgl_lahir->diffInMonths(now());
    }
}
