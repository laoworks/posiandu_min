<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Pengaturan Website';
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?int $navigationSort = 1;

    public static function canViewAny(): bool
    {
        return Auth::user()->level === 'admin';
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        $record = $form->getRecord();
        $key = $record?->key;

        if ($key === 'website_name') {
            return $form->schema([
                Forms\Components\TextInput::make('value')
                    ->label('Nama Website')
                    ->required()
                    ->maxLength(50)
                    ->helperText('Nama singkat yang tampil di menu atas'),
            ]);
        }

        if ($key === 'website_subtitle') {
            return $form->schema([
                Forms\Components\TextInput::make('value')
                    ->label('Subtitle')
                    ->required()
                    ->maxLength(100)
                    ->helperText('Nama desa atau lokasi posyandu'),
            ]);
        }

        if ($key === 'website_fullname') {
            return $form->schema([
                Forms\Components\Textarea::make('value')
                    ->label('Nama Lengkap')
                    ->required()
                    ->rows(3)
                    ->helperText('Nama lengkap website yang tampil di halaman utama'),
            ]);
        }

        if ($key === 'logo_path') {
            return $form->schema([
                Forms\Components\FileUpload::make('value')
                    ->label('Upload Logo')
                    ->directory('logo')
                    ->image()
                    ->maxSize(1024)
                    ->helperText('Ukuran gambar disarankan 200x200 pixel'),
            ]);
        }

        if ($key === 'favicon_path') {
            return $form->schema([
                Forms\Components\FileUpload::make('value')
                    ->label('Upload Favicon')
                    ->directory('favicon')
                    ->image()
                    ->maxSize(512)
                    ->helperText('Ukuran gambar disarankan 32x32 pixel'),
            ]);
        }

        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->label('Pengaturan')
                    ->formatStateUsing(function ($state) {
                        $labels = [
                            'website_name' => 'Nama Website',
                            'website_subtitle' => 'Subtitle',
                            'website_fullname' => 'Nama Lengkap',
                            'logo_path' => 'Logo',
                            'favicon_path' => 'Favicon',
                        ];
                        return $labels[$state] ?? $state;
                    }),
                Tables\Columns\TextColumn::make('value')
                    ->label('Isi')
                    ->limit(40)
                    ->formatStateUsing(function ($state, $record) {
                        if (!$record) {
                            return '-';
                        }
                        if (in_array($record->key, ['logo_path', 'favicon_path'])) {
                            return $state ? basename($state) : 'Kosong';
                        }
                        return $state ?: 'Kosong';
                    }),
                Tables\Columns\ImageColumn::make('value')
                    ->label('')
                    ->width(40)
                    ->height(40)
                    ->visible(function ($record) {
                        if (!$record) {
                            return false;
                        }
                        return in_array($record->key, ['logo_path', 'favicon_path']);
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Edit')
                    ->icon('heroicon-o-pencil'),
            ])
            ->paginated(false);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSettings::route('/'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
