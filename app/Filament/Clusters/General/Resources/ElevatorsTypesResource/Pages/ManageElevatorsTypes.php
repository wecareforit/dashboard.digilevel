<?php
namespace App\Filament\Clusters\General\Resources\ElevatorsTypesResource\Pages;

use App\Filament\Clusters\General\Resources\ElevatorsTypesResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Enums\MaxWidth;

class ManageElevatorsTypes extends ManageRecords
{
    protected static string $resource = ElevatorsTypesResource::class;
    protected static ?string $title   = 'Object - Types';

    protected function getHeaderActions(): array
    {
        return [

            \EightyNine\ExcelImport\ExcelImportAction::make()->label('Importeren')
                ->color("primary")
                ->link(),
            Actions\CreateAction::make()->icon('heroicon-m-plus')->modalHeading('Toevoegen')->label('Toevoegen')->modalWidth(MaxWidth::ExtraLarge),
        ];
    }
}
