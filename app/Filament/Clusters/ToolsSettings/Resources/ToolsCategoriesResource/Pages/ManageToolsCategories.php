<?php
namespace App\Filament\Clusters\ToolsSettings\Resources\ToolsCategoriesResource\Pages;

use App\Filament\Clusters\ToolsSettings\Resources\ToolsCategoriesResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Enums\MaxWidth;

class ManageToolsCategories extends ManageRecords
{

    protected static ?string $title = 'Gereedschap - Categorieën';

    protected static string $resource = ToolsCategoriesResource::class;

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

            Actions\CreateAction::make()->modalWidth(MaxWidth::Large)->label('Toevoegen')->modalHeading('Toevoegen'),
        ];
    }
}
