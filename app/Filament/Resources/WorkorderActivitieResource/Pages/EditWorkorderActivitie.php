<?php

namespace App\Filament\Resources\WorkorderActivitieResource\Pages;

use App\Filament\Resources\WorkorderActivitieResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWorkorderActivitie extends EditRecord
{
    protected static string $resource = WorkorderActivitieResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
