<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Imunisasi extends Model
{
    use HasFactory;

    protected $table = 'imunisasi';
    protected $primaryKey = 'id_imunisasi';

    protected $fillable = [
        'tgl_penimbangan',
        'nik_anak',
        'usia',
        'jenis_imunisasi'
    ];

    protected $casts = [
        'tgl_penimbangan' => 'date',
    ];

    public function anak()
    {
        return $this->belongsTo(Anak::class, 'nik_anak', 'nik_anak');
    }
}
