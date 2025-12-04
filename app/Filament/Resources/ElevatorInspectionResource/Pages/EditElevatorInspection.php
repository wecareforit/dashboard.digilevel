<?php

namespace App\Filament\Resources\ElevatorInspectionResource\Pages;

use App\Filament\Resources\ElevatorInspectionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditElevatorInspection extends EditRecord
{
    protected static string $resource = ElevatorInspectionResource::class;

    public function getSubheading(): ?string
    {
        if ($this->getRecord()->schedule_run_token) {
            return "Geimporteerd vanuit de koppeling met " . $this->getRecord()?->inspectioncompany?->name;
        } else {
            return "";
        }

    }
}
