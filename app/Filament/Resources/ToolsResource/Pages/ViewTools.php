<?php
namespace App\Filament\Resources\ToolsResource\Pages;

use App\Filament\Resources\ToolsResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Enums\MaxWidth;

class ViewTools extends ViewRecord
{
    protected static string $resource = ToolsResource::class;

    protected function getHeaderActions():
    array {
        return [
            Action::make('back')
                ->url(route('filament.app.resources.tools.index'))
                ->label('Terug naar overzicht')
                ->link()
                ->color('gray'),
            Actions\EditAction::make()->icon('heroicon-m-pencil-square')->modalWidth(MaxWidth::SevenExtraLarge),
            Actions\DeleteAction::make()->icon('heroicon-m-trash'),
        ];
    }
    public function getHeading(): string
    {
        return $this->getRecord()->name;
    }
    public function getTitle(): string
    {
        return $this->getRecord()->name;
    }

}
