<?php

namespace App\Filament\Resources\Connection\elevators\chexResource\Pages;

use App\Filament\Resources\Connection\elevators\chexResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class Listchexes extends ListRecords
{
    protected static string $resource = chexResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
