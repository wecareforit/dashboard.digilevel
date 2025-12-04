<?php

namespace App\Filament\Clusters\General\Resources\ObjectInspectionZincodeResource\Pages;

use App\Filament\Clusters\General\Resources\ObjectInspectionZincodeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditObjectInspectionZincode extends EditRecord
{
    protected static string $resource = ObjectInspectionZincodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
