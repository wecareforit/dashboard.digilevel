<?php

namespace App\Filament\Clusters\General\Resources\ObjectInspectionZincodeResource\Pages;

use App\Filament\Clusters\General\Resources\ObjectInspectionZincodeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListObjectInspectionZincodes extends ListRecords
{
    protected static ?string $title = 'Objecten - ZIN Codes';
    protected static string $resource = ObjectInspectionZincodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \EightyNine\ExcelImport\ExcelImportAction::make()
                ->color("success")
                ->link()
                ->color('primary')
                ->label('Importeren')
                ->modalHeading('Selecteer een excel bestand'),
             Actions\CreateAction::make()->label('Toevoegen')->modalHeading('Toevoegen'),

        ];
    }
}
