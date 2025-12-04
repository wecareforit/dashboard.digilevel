<?php

namespace App\Filament\Resources\Connection\elevators\liftinstituutResource\Pages;

use App\Filament\Resources\Connection\elevators\liftinstituutResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class Editliftinstituut extends EditRecord
{
    protected static string $resource = liftinstituutResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
