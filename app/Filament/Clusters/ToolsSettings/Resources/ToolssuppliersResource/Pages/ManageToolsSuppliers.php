<?php
namespace App\Filament\Clusters\ToolsSettings\Resources\ToolsSuppliersResource\Pages;

use App\Filament\Clusters\ToolsSettings\Resources\ToolsSuppliersResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ManageRecords;

class ManageToolsSuppliers extends ManageRecords
{
    protected static ?string $title = 'Gereedschap - Leveranciers';

    protected static string $resource = ToolsSuppliersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->url(route('filament.app.resources.tools.index'))
                ->label('Terug naar gereedschappen')
                ->link()
                ->color('gray'),
            Actions\CreateAction::make()->label('Toevoegen')->modalHeading('Toevoegen'),
        ];
    }
}
