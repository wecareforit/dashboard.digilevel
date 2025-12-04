<?php

namespace App\Filament\Clusters\General\Resources\UploadsTypesResource\Pages;

use App\Filament\Clusters\General\Resources\UploadsTypesResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Enums\MaxWidth;

class ManageUploadsTypes extends ManageRecords
{
    protected static string $resource = UploadsTypesResource::class;
    protected static ?string $title = 'Algemeen - Upload types';

    protected function getHeaderActions(): array
    {
        return [
            \EightyNine\ExcelImport\ExcelImportAction::make()
            ->label('Importeren')
            ->outlined()
            ->link()
            ->color('primary') 
         ->modalHeading('Selecteer een excel bestand'),
                Actions\CreateAction::make()->label('Toevoegen')->modalHeading('Toevoegen')->modalWidth(MaxWidth::ExtraLarge),
 
        ];
    }
}
