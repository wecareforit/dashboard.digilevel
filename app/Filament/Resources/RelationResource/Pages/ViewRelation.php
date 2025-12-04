<?php
namespace App\Filament\Resources\RelationResource\Pages;

use App\Filament\Resources\RelationResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Filament\Tables\Actions\ActionGroup;
use Parallax\FilamentComments\Actions\CommentsAction;

class ViewRelation extends ViewRecord
{
    protected static string $resource = RelationResource::class;
    protected function getHeaderActions():
    array {
        return [
            Action::make('back')
                ->label('Terug naar overzicht')
                ->link()

                ->url(url()->previous())
                ->color('gray'),

            Actions\EditAction::make()->icon('heroicon-m-pencil-square')
                ->slideOver()
            ,

            CommentsAction::make(),

            ActionGroup::make([
                Actions\DeleteAction::make('Verwijderen'),
            ]),

        ];
    }

    public function getTitle(): string
    {
        return $this->getRecord()->name;
    }
}
