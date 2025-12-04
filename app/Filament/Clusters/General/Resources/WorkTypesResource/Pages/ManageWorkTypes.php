<?php

namespace App\Filament\Clusters\General\Resources\WorkTypesResource\Pages;

use App\Filament\Clusters\General\Resources\WorkTypesResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Enums\MaxWidth;


class ManageWorkTypes extends ManageRecords
{
    protected static string $resource = WorkTypesResource::class;
    protected static ?string $title = 'Algemeen - Werkomschrijvingen';
    protected function getHeaderActions(): array
    {
        return [
            \EightyNine\ExcelImport\ExcelImportAction::make()
            ->color("success")->label('Importeren')->modalHeading('Selecteer een excel bestand'),
    
            Actions\CreateAction::make()->modalWidth(MaxWidth::ExtraLarge)->label('Toevoegen')->modalHeading('Toevoegen'),

        ];
    }
}
