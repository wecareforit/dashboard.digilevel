<?php
namespace App\Filament\Resources\RelationLocationResource\Pages;

use App\Filament\Resources\RelationLocationResource;
 
use Filament\Resources\Pages\ViewRecord;
use Parallax\FilamentComments\Actions\CommentsAction;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
class ViewRelationLocation extends ViewRecord
{
    protected static string $resource = RelationLocationResource::class;

    protected function getHeaderActions(): array
    {
        return [

                        Action::make('back')
                ->label('Terug naar overzicht')
                ->link()
                ->url(url()->previous())
                ->color('gray'),


            Actions\EditAction::make()->label('Wijzigen')
            ->slideOver()
                ->icon('heroicon-m-pencil-square'),
            CommentsAction::make(),

                    ActionGroup::make([
                Actions\DeleteAction::make('Verwijderen'),
            ]),
        ];
    }

    public function getTitle(): string
    {
        return $this->getRecord()?->address . " " . $this->getRecord()?->housenumber . ", " . $this->getRecord()?->zipcode . " " . $this->getRecord()?->place;
    }
}
