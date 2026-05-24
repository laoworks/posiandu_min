<?php

namespace App\Filament\Exports;

use App\Models\Penimbangan;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class PenimbanganExporter extends Exporter
{
    protected static ?string $model = Penimbangan::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id_penimbangan')
                ->label('ID Penimbangan'),
            ExportColumn::make('anak.nama_anak')
                ->label('Nama Anak'),
            ExportColumn::make('anak.nik_anak')
                ->label('NIK Anak'),
            ExportColumn::make('tgl_penimbangan')
                ->label('Tanggal Penimbangan')
                ->formatStateUsing(fn($state) => $state ? date('d/m/Y', strtotime($state)) : '-'),
            ExportColumn::make('usia')
                ->label('Usia (bulan)'),
            ExportColumn::make('berat_badan')
                ->label('Berat Badan (kg)'),
            ExportColumn::make('keterangan')
                ->label('Keterangan')
                ->formatStateUsing(fn($state) => match ($state) {
                    'naik' => 'Naik',
                    'tetap' => 'Tetap',
                    'turun' => 'Turun',
                    default => $state,
                }),
            ExportColumn::make('status_gizi')
                ->label('Status Gizi'),
            ExportColumn::make('saran')
                ->label('Saran'),
            ExportColumn::make('created_at')
                ->label('Dibuat Pada')
                ->formatStateUsing(fn($state) => $state ? date('d/m/Y H:i', strtotime($state)) : '-'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = '✅ Export data penimbangan selesai! ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' berhasil di export.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ❌ ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' gagal di export.';
        }

        return $body;
    }
}
