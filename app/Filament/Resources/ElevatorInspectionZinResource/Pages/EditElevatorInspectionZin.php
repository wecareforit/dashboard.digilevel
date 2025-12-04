<?php

namespace App\Filament\Resources\ElevatorInspectionZinResource\Pages;

use App\Filament\Resources\ElevatorInspectionZinResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditElevatorInspectionZin extends EditRecord
{
    protected static string $resource = ElevatorInspectionZinResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
