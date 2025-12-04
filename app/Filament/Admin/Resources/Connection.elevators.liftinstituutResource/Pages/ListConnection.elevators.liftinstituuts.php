<?php

namespace App\Filament\Admin\Resources\Connection.elevators.liftinstituutResource\Pages;

use App\Filament\Admin\Resources\Connection.elevators.liftinstituutResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListConnection.elevators.liftinstituuts extends ListRecords
{
    protected static string $resource = Connection.elevators.liftinstituutResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
