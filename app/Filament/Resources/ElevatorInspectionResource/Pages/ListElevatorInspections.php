<?php

namespace App\Filament\Resources\ElevatorInspectionResource\Pages;

use App\Filament\Resources\ElevatorInspectionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Asmit\ResizedColumn\HasResizableColumn;

class ListElevatorInspections extends ListRecords
{
    protected static string $resource = ElevatorInspectionResource::class;
    use HasResizableColumn;
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
