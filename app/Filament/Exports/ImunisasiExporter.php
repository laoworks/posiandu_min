<?php

namespace App\Filament\Exports;

use App\Models\Imunisasi;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class ImunisasiExporter extends Exporter
{
    protected static ?string $model = Imunisasi::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id_imunisasi')
                ->label('ID Imunisasi'),
            ExportColumn::make('anak.nama_anak')
                ->label('Nama Anak'),
            ExportColumn::make('anak.nik_anak')
                ->label('NIK Anak'),
            ExportColumn::make('tgl_penimbangan')
                ->label('Tanggal Imunisasi')
                ->formatStateUsing(fn($state) => $state ? date('d/m/Y', strtotime($state)) : '-'),
            ExportColumn::make('usia')
                ->label('Usia (bulan)'),
            ExportColumn::make('jenis_imunisasi')
                ->label('Jenis Imunisasi'),
            ExportColumn::make('created_at')
                ->label('Dibuat Pada')
                ->formatStateUsing(fn($state) => $state ? date('d/m/Y H:i', strtotime($state)) : '-'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = '✅ Export data imunisasi selesai! ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' berhasil di export.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ❌ ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' gagal di export.';
        }

        return $body;
    }
}
