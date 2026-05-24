<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PenimbanganResource\Pages;
use App\Models\Penimbangan;
use App\Models\Anak;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class PenimbanganResource extends Resource
{
    protected static ?string $model = Penimbangan::class;
    protected static ?string $navigationIcon = 'heroicon-o-scale';
    protected static ?string $navigationLabel = 'Penimbangan';
    protected static ?string $navigationGroup = 'Transaksi';

    // ========== PEMBATASAN AKSES ==========

    public static function canViewAny(): bool
    {
        return in_array(Auth::user()->level, ['admin', 'petugas', 'kader']);
    }

    public static function canCreate(): bool
    {
        return in_array(Auth::user()->level, ['admin', 'petugas']);
    }

    public static function canEdit($record): bool
    {
        return in_array(Auth::user()->level, ['admin', 'petugas']);
    }

    public static function canDelete($record): bool
    {
        return Auth::user()->level === 'admin';
    }

    public static function canDeleteAny(): bool
    {
        return Auth::user()->level === 'admin';
    }

    // ========== FORM ==========

    public static function form(Form $form): Form
    {
        $isKader = Auth::user()->level === 'kader';

        return $form
            ->schema([
                Forms\Components\Section::make('Data Penimbangan')
                    ->schema([
                        Forms\Components\Select::make('nik_anak')
                            ->label('Nama Anak')
                            ->relationship('anak', 'nama_anak')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->disabled($isKader)
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state) {
                                    $anak = Anak::find($state);
                                    if ($anak) {
                                        $set('jenis_kelamin', $anak->jenis_kelamin);
                                        $usia = $anak->tgl_lahir->diffInMonths(now());
                                        $set('usia', $usia);

                                        $berat = request()->input('berat_badan');
                                        if ($berat) {
                                            $status = Penimbangan::hitungStatusGizi($usia, $berat, $anak->jenis_kelamin);
                                            $set('status_gizi', $status);
                                            $set('saran', Penimbangan::generateSaran($status));
                                        }
                                    }
                                }
                            }),

                        Forms\Components\Hidden::make('jenis_kelamin'),
                        Forms\Components\Hidden::make('usia'),

                        Forms\Components\DatePicker::make('tgl_penimbangan')
                            ->label('Tanggal Penimbangan')
                            ->required()
                            ->default(now())
                            ->disabled($isKader)
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                $nikAnak = $get('nik_anak');
                                if ($nikAnak && $state) {
                                    $anak = Anak::find($nikAnak);
                                    if ($anak) {
                                        $usia = $anak->tgl_lahir->diffInMonths($state);
                                        $set('usia', $usia);

                                        $berat = $get('berat_badan');
                                        if ($berat) {
                                            $status = Penimbangan::hitungStatusGizi($usia, $berat, $anak->jenis_kelamin);
                                            $set('status_gizi', $status);
                                            $set('saran', Penimbangan::generateSaran($status));
                                        }
                                    }
                                }
                            }),

                        Forms\Components\TextInput::make('berat_badan')
                            ->label('Berat Badan (kg)')
                            ->required()
                            ->numeric()
                            ->step(0.1)
                            ->minValue(0.5)
                            ->maxValue(50)
                            ->disabled($isKader)
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                $usia = $get('usia');
                                $jk = $get('jenis_kelamin');

                                if ($usia && $state && $jk) {
                                    $status = Penimbangan::hitungStatusGizi($usia, $state, $jk);
                                    $set('status_gizi', $status);
                                    $set('saran', Penimbangan::generateSaran($status));
                                }
                            }),

                        Forms\Components\Select::make('keterangan')
                            ->label('Keterangan')
                            ->options([
                                'naik' => 'Naik',
                                'tetap' => 'Tetap',
                                'turun' => 'Turun'
                            ])
                            ->required()
                            ->disabled($isKader),

                        Forms\Components\TextInput::make('status_gizi')
                            ->label('Status Gizi')
                            ->disabled()
                            ->dehydrated(true)
                            ->formatStateUsing(fn($state) => $state ?? 'Akan terisi otomatis'),

                        Forms\Components\Textarea::make('saran')
                            ->label('Saran')
                            ->rows(3)
                            ->disabled($isKader)
                            ->placeholder('Saran akan terisi otomatis berdasarkan status gizi'),
                    ])->columns(2),
            ]);
    }

    // ========== TABLE ==========

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('anak.nama_anak')
                    ->label('Nama Anak')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tgl_penimbangan')
                    ->label('Tanggal')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('usia')
                    ->label('Usia (bulan)')
                    ->sortable(),
                Tables\Columns\TextColumn::make('berat_badan')
                    ->label('Berat (kg)')
                    ->suffix(' kg')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status_gizi')
                    ->label('Status Gizi')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Gizi Kurang' => 'danger',
                        'Gizi Baik' => 'success',
                        'Gizi Lebih' => 'warning',
                        'Gizi Buruk' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'naik' => 'success',
                        'tetap' => 'info',
                        'turun' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status_gizi')
                    ->options([
                        'Gizi Buruk' => 'Gizi Buruk',
                        'Gizi Kurang' => 'Gizi Kurang',
                        'Gizi Baik' => 'Gizi Baik',
                        'Gizi Lebih' => 'Gizi Lebih',
                    ]),
                Tables\Filters\Filter::make('tgl_penimbangan')
                    ->form([
                        Forms\Components\DatePicker::make('from')->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('until')->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'], fn($q) => $q->whereDate('tgl_penimbangan', '>=', $data['from']))
                            ->when($data['until'], fn($q) => $q->whereDate('tgl_penimbangan', '<=', $data['until']));
                    }),
            ])
            // ========== HEADER ACTIONS - EXPORT LANGSUNG (TANPA QUEUE) ==========
            ->headerActions([
                \Filament\Tables\Actions\Action::make('exportExcel')
                    ->label('Export CSV')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->visible(fn() => Auth::user()->level === 'admin')
                    ->action(function () {
                        // Ambil semua data penimbangan
                        $data = \App\Models\Penimbangan::with('anak')->get();

                        // Buat file CSV
                        $filename = 'penimbangan_' . date('Y-m-d_H-i-s') . '.csv';

                        // Header CSV
                        $headers = [
                            'Content-Type' => 'text/csv',
                            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                        ];

                        // Buat callback untuk output CSV
                        $callback = function () use ($data) {
                            $file = fopen('php://output', 'w');

                            // Header kolom
                            fputcsv($file, ['ID', 'Nama Anak', 'NIK Anak', 'Tanggal Penimbangan', 'Usia (bulan)', 'Berat Badan (kg)', 'Keterangan', 'Status Gizi', 'Saran']);

                            // Data
                            foreach ($data as $row) {
                                // Mapping keterangan
                                $keterangan = match ($row->keterangan) {
                                    'naik' => 'Naik',
                                    'tetap' => 'Tetap',
                                    'turun' => 'Turun',
                                    default => $row->keterangan ?? '-',
                                };

                                fputcsv($file, [
                                    $row->id_penimbangan,
                                    $row->anak->nama_anak ?? '-',
                                    $row->nik_anak,
                                    $row->tgl_penimbangan,
                                    $row->usia,
                                    $row->berat_badan ? $row->berat_badan . ' kg' : '-',
                                    $keterangan,
                                    $row->status_gizi ?? '-',
                                    $row->saran ?? '-',
                                ]);
                            }

                            fclose($file);
                        };

                        return response()->stream($callback, 200, $headers);
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->visible(fn() => in_array(Auth::user()->level, ['admin', 'petugas'])),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn() => Auth::user()->level === 'admin'),
            ])
            ->defaultSort('tgl_penimbangan', 'desc');
    }

    // ========== PAGES ==========

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPenimbangans::route('/'),
            'create' => Pages\CreatePenimbangan::route('/create'),
            'edit' => Pages\EditPenimbangan::route('/{record}/edit'),
        ];
    }
}
