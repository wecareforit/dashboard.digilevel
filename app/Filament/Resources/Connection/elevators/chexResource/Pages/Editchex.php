<?php

namespace App\Filament\Resources\Connection\elevators\chexResource\Pages;

use App\Filament\Resources\Connection\elevators\chexResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class Editchex extends EditRecord
{
    protected static string $resource = chexResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
