<?php

namespace App\Filament\Clusters\General\Resources\HourTypesResource\Pages;

use App\Filament\Clusters\General\Resources\HourTypesResource;


 

use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Enums\MaxWidth;
use Filament\Actions\Action;


class ManageHourTypes extends ManageRecords
{
    protected static string $resource = HourTypesResource::class;
    protected static ?string $title = 'Projecten - Uurtypes';
    protected function getHeaderActions(): array
    {
        return [
            \EightyNine\ExcelImport\ExcelImportAction::make()
                ->link()
                ->color("success")
                ->label('Importeren')
                ->color('primary')
                ->modalHeading('Selecteer een excel bestand'),
            Actions\CreateAction::make() ->icon('heroicon-m-plus')
                ->modalHeading('Toevoegen')
                ->label('Toevoegen')
                ->modalWidth(MaxWidth::ExtraLarge),
        ];
    }
}
//filament.{panel_id}.resources.{resource_name}