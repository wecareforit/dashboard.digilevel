<?php

namespace App\Filament\Resources\ElevatorResource\Pages;

use App\Filament\Resources\ElevatorResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditElevator extends EditRecord
{
    protected static string $resource = ElevatorResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
