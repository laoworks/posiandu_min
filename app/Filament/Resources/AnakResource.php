<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnakResource\Pages;
use App\Models\Anak;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class AnakResource extends Resource
{
    protected static ?string $model = Anak::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Data Anak';
    protected static ?string $navigationGroup = 'Data Master';

    // ========== PEMBATASAN AKSES BERDASARKAN ROLE ==========

    public static function canViewAny(): bool
    {
        $user = Auth::user();
        return in_array($user->level, ['admin', 'petugas', 'kader']);
    }

    public static function canCreate(): bool
    {
        $user = Auth::user();
        return in_array($user->level, ['admin', 'petugas']);
    }

    public static function canEdit($record): bool
    {
        $user = Auth::user();
        return in_array($user->level, ['admin', 'petugas']);
    }

    public static function canDelete($record): bool
    {
        $user = Auth::user();
        return $user->level === 'admin';
    }

    public static function canDeleteAny(): bool
    {
        $user = Auth::user();
        return $user->level === 'admin';
    }

    public static function canForceDelete($record): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        $isKader = Auth::user()->level === 'kader';

        return $form
            ->schema([
                Forms\Components\Section::make('Identitas Anak')
                    ->schema([
                        Forms\Components\TextInput::make('nik_anak')
                            ->label('NIK Anak')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(16)
                            ->disabled($isKader),
                        Forms\Components\TextInput::make('no_kk')
                            ->label('No. KK')
                            ->required()
                            ->maxLength(16)
                            ->disabled($isKader),
                        Forms\Components\TextInput::make('nama_anak')
                            ->label('Nama Anak')
                            ->required()
                            ->maxLength(100)
                            ->disabled($isKader),
                        Forms\Components\Select::make('jenis_kelamin')
                            ->options([
                                'L' => 'Laki-laki',
                                'P' => 'Perempuan'
                            ])
                            ->required()
                            ->disabled($isKader),
                        Forms\Components\DatePicker::make('tgl_lahir')
                            ->required()
                            ->disabled($isKader),
                        Forms\Components\TextInput::make('anak_ke')
                            ->label('Anak ke-')
                            ->numeric()
                            ->minValue(1)
                            ->disabled($isKader),
                    ])->columns(2),

                Forms\Components\Section::make('Data Orang Tua')
                    ->schema([
                        Forms\Components\TextInput::make('nama_ayah')
                            ->maxLength(100)
                            ->disabled($isKader),
                        Forms\Components\TextInput::make('nama_ibu')
                            ->maxLength(100)
                            ->disabled($isKader),
                        Forms\Components\TextInput::make('bb_lahir')
                            ->label('Berat Badan Lahir (gram)')
                            ->numeric()
                            ->disabled($isKader),
                        Forms\Components\TextInput::make('panjang_lahir')
                            ->label('Panjang Lahir (cm)')
                            ->numeric()
                            ->disabled($isKader),
                        Forms\Components\Textarea::make('alamat')
                            ->maxLength(65535)
                            ->columnSpanFull()
                            ->disabled($isKader),
                        Forms\Components\TextInput::make('no_hp_ortu')
                            ->label('No. HP Orang Tua')
                            ->tel()
                            ->maxLength(15)
                            ->disabled($isKader),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nik_anak')
                    ->label('NIK')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_anak')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenis_kelamin')
                    ->label('JK')
                    ->formatStateUsing(fn($state) => $state == 'L' ? 'Laki' : 'Perempuan'),
                Tables\Columns\TextColumn::make('tgl_lahir')
                    ->date(),
                Tables\Columns\TextColumn::make('nama_ayah'),
                Tables\Columns\TextColumn::make('nama_ibu'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('jenis_kelamin')
                    ->options(['L' => 'Laki-laki', 'P' => 'Perempuan']),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->visible(fn() => in_array(Auth::user()->level, ['admin', 'petugas'])),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn() => Auth::user()->level === 'admin'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn() => Auth::user()->level === 'admin'),
                ]),
            ]);
    }

    // ========== PAGES - TANPA MIDDLEWARE DI SINI ==========
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAnaks::route('/'),
            'create' => Pages\CreateAnak::route('/create'),
            'edit' => Pages\EditAnak::route('/{record}/edit'),
        ];
    }
}
