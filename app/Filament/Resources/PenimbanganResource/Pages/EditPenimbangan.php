<?php

namespace App\Filament\Resources\PenimbanganResource\Pages;

use App\Filament\Resources\PenimbanganResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPenimbangan extends EditRecord
{
    protected static string $resource = PenimbanganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
