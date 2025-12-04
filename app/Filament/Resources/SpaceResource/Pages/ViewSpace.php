<?php
namespace App\Filament\Resources\SpaceResource\Pages;

use App\Filament\Resources\SpaceResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Filament\Tables\Actions\ActionGroup;

class ViewSpace extends ViewRecord
{
    protected static string $resource = SpaceResource::class;

    protected function getHeaderActions():
    array {
        return [
            Action::make('back')
                ->label('Terug naar overzicht')
                ->link()
                ->url(url()->previous())
                ->color('gray'),

            Actions\EditAction::make()->icon('heroicon-m-pencil-square')
            ,

            ActionGroup::make([
                Actions\DeleteAction::make('Verwijderen'),
            ]),

        ];
    }

    public function getHeading(): string
    {
        return "Bekijk ruimte";
    }

}
