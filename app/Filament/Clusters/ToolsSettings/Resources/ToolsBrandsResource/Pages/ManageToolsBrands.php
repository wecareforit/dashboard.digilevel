<?php
namespace App\Filament\Clusters\ToolsSettings\Resources\ToolsBrandsResource\Pages;

use App\Filament\Clusters\ToolsSettings\Resources\ToolsBrandsResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Enums\MaxWidth;

class ManageToolsBrands extends ManageRecords
{
    protected static string $resource = ToolsBrandsResource::class;
    protected static ?string $title   = 'Gereedschap - Merken';

    protected function getHeaderActions(): array
    {
        return [

            Action::make('back')
                ->url(route('filament.app.resources.tools.index'))
                ->label('Terug naar gereedschappen')
                ->link()
                ->color('gray'),

            \EightyNine\ExcelImport\ExcelImportAction::make()
                ->color("success")->label('Importeren')->modalHeading('Selecteer een excel bestand'),
            Actions\CreateAction::make()->modalWidth(MaxWidth::ExtraLarge)->label('Toevoegen')->modalHeading('Toevoegen'),
        ];
    }
}
