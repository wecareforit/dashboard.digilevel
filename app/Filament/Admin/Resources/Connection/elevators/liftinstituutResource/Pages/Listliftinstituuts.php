<?php

namespace App\Filament\Admin\Resources\Connection\elevators\liftinstituutResource\Pages;

use App\Filament\Admin\Resources\Connection\elevators\liftinstituutResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class Listliftinstituuts extends ListRecords
{
    protected static string $resource = liftinstituutResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
