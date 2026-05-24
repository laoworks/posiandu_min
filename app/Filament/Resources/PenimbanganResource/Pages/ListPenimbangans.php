<?php

namespace App\Filament\Resources\PenimbanganResource\Pages;

use App\Filament\Resources\PenimbanganResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPenimbangans extends ListRecords
{
    protected static string $resource = PenimbanganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
