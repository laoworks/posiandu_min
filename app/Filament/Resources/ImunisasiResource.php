<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ImunisasiResource\Pages;
use App\Models\Imunisasi;
use App\Models\Anak;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class ImunisasiResource extends Resource
{
    protected static ?string $model = Imunisasi::class;
    protected static ?string $navigationIcon = 'heroicon-o-beaker';
    protected static ?string $navigationLabel = 'Imunisasi';
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
                Forms\Components\Section::make('Data Imunisasi')
                    ->schema([
                        Forms\Components\Select::make('nik_anak')
                            ->label('Nama Anak')
                            ->relationship('anak', 'nama_anak')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->disabled($isKader)
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state) {
                                    $anak = Anak::find($state);
                                    if ($anak) {
                                        $tglPenimbangan = request()->input('tgl_penimbangan') ?? now();
                                        $usia = $anak->tgl_lahir->diffInMonths($tglPenimbangan);
                                        $set('usia', $usia);
                                    }
                                }
                            })
                            ->live(),

                        Forms\Components\Hidden::make('usia')
                            ->default(0),

                        Forms\Components\DatePicker::make('tgl_penimbangan')
                            ->label('Tanggal Imunisasi')
                            ->required()
                            ->default(now())
                            ->disabled($isKader)
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                $nikAnak = $get('nik_anak');
                                if ($nikAnak && $state) {
                                    $anak = Anak::find($nikAnak);
                                    if ($anak) {
                                        $usia = $anak->tgl_lahir->diffInMonths($state);
                                        $set('usia', $usia);
                                    }
                                }
                            }),

                        Forms\Components\Select::make('jenis_imunisasi')
                            ->label('Jenis Imunisasi')
                            ->options([
                                'BCG' => 'BCG',
                                'DPT' => 'DPT',
                                'Polio' => 'Polio',
                                'Campak' => 'Campak',
                                'Hepatitis B' => 'Hepatitis B',
                                'Hib' => 'Hib',
                                'Rotavirus' => 'Rotavirus',
                                'PCV' => 'PCV',
                                'JE' => 'Japanese Encephalitis',
                            ])
                            ->required()
                            ->searchable()
                            ->disabled($isKader),
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
                    ->label('Tanggal Imunisasi')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('usia')
                    ->label('Usia (bulan)')
                    ->sortable(),
                Tables\Columns\TextColumn::make('jenis_imunisasi')
                    ->label('Jenis Imunisasi')
                    ->badge()
                    ->color('success'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('jenis_imunisasi')
                    ->options([
                        'BCG' => 'BCG',
                        'DPT' => 'DPT',
                        'Polio' => 'Polio',
                        'Campak' => 'Campak',
                        'Hepatitis B' => 'Hepatitis B',
                        'Hib' => 'Hib',
                        'Rotavirus' => 'Rotavirus',
                        'PCV' => 'PCV',
                        'JE' => 'Japanese Encephalitis',
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
            // ========== HEADER ACTIONS - EXPORT LANGSUNG ==========
            ->headerActions([
                \Filament\Tables\Actions\Action::make('exportExcel')
                    ->label('Export Excel')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->visible(fn() => Auth::user()->level === 'admin')
                    ->action(function () {
                        // Ambil semua data imunisasi
                        $data = \App\Models\Imunisasi::with('anak')->get();

                        // Buat file CSV
                        $filename = 'imunisasi_' . date('Y-m-d_H-i-s') . '.csv';

                        // Header CSV
                        $headers = [
                            'Content-Type' => 'text/csv',
                            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                        ];

                        // Buat callback untuk output CSV
                        $callback = function () use ($data) {
                            $file = fopen('php://output', 'w');

                            // Header kolom
                            fputcsv($file, ['ID', 'Nama Anak', 'NIK Anak', 'Tanggal Imunisasi', 'Usia (bulan)', 'Jenis Imunisasi']);

                            // Data
                            foreach ($data as $row) {
                                fputcsv($file, [
                                    $row->id_imunisasi,
                                    $row->anak->nama_anak ?? '-',
                                    $row->nik_anak,
                                    $row->tgl_penimbangan,
                                    $row->usia,
                                    $row->jenis_imunisasi,
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
            'index' => Pages\ListImunisasis::route('/'),
            'create' => Pages\CreateImunisasi::route('/create'),
            'edit' => Pages\EditImunisasi::route('/{record}/edit'),
        ];
    }
}
