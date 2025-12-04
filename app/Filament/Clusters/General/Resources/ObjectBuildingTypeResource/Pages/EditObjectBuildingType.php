<?php

namespace App\Filament\Clusters\General\Resources\ObjectBuildingTypeResource\Pages;

use App\Filament\Clusters\General\Resources\ObjectBuildingTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditObjectBuildingType extends EditRecord
{
    protected static string $resource = ObjectBuildingTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
