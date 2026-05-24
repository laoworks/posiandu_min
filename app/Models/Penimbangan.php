<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penimbangan extends Model
{
    use HasFactory;

    protected $table = 'penimbangan';
    protected $primaryKey = 'id_penimbangan';

    protected $fillable = [
        'tgl_penimbangan',
        'nik_anak',
        'jenis_kelamin',
        'usia',
        'berat_badan',
        'keterangan',
        'status_gizi',
        'saran'
    ];

    protected $casts = [
        'tgl_penimbangan' => 'date',
        'berat_badan' => 'float',
    ];

    public function anak()
    {
        return $this->belongsTo(Anak::class, 'nik_anak', 'nik_anak');
    }

    public static function exportToCsv()
    {
        $data = self::with('anak')->get();

        $filename = 'penimbangan_' . date('Y-m-d_H-i-s') . '.csv';
        $handle = fopen('php://output', 'w');

        // Header CSV
        fputcsv($handle, ['ID', 'Nama Anak', 'NIK', 'Tanggal', 'Usia', 'Berat', 'Keterangan', 'Status Gizi', 'Saran']);

        foreach ($data as $row) {
            fputcsv($handle, [
                $row->id_penimbangan,
                $row->anak->nama_anak ?? '-',
                $row->nik_anak,
                $row->tgl_penimbangan,
                $row->usia,
                $row->berat_badan,
                $row->keterangan,
                $row->status_gizi,
                $row->saran,
            ]);
        }

        fclose($handle);

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        exit;
    }
}
