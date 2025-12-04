<?php
namespace App\Filament\Resources\ToolsResource\Pages;

use App\Filament\Resources\ToolsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;

class ListTools extends ListRecords
{
    protected static string $resource = ToolsResource::class;
    protected static ?string $title   = 'Gereedschap - Overzicht';

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('settings')
                ->icon('heroicon-o-cog-6-tooth')
                ->color('gray')
                ->label('Instellingen')
                ->url(route('filament.app.tools-settings'))
                ->link()
                ->outlined(),

            Actions\CreateAction::make()
                ->modalWidth(MaxWidth::SevenExtraLarge)
                ->modalHeading('Gereedschap toevoegen')
                ->modalDescription('Voeg nieuw gereedschap toe door de onderstaande gegevens in te vullen.')
                ->icon('heroicon-m-plus')
                ->modalIcon('heroicon-o-plus')

                ->label('Gereedschap toevoegen'),
        ];
    }

    public function getHeading(): string
    {
        return static::$title;
    }
}
