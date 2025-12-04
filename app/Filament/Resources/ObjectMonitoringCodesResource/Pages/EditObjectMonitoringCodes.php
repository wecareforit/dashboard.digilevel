<?php

namespace App\Filament\Resources\ObjectMonitoringCodesResource\Pages;

use App\Filament\Resources\ObjectMonitoringCodesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditObjectMonitoringCodes extends EditRecord
{
    protected static string $resource = ObjectMonitoringCodesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
