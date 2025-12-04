<?php
namespace App\Filament\Resources\ObjectResource\Pages;

use App\Filament\Resources\ObjectResource;
use Filament\Resources\Pages\ListRecords;
use Relaticle\CustomFields\Filament\Tables\Concerns\InteractsWithCustomFields;

class ListObjects extends ListRecords
{
    protected static string $resource = ObjectResource::class;
    use InteractsWithCustomFields;
    protected static ?string $title = 'Objecten';

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\CreateAction::make()
    //             ->modalWidth(MaxWidth::FourExtraLarge)
    //             ->modalHeading('Object toevoegen')
    //             ->modalDescription('Voeg een nieuwe object toe door de onderstaande gegeven zo volledig mogelijk in te vullen.')
    //             ->icon('heroicon-m-plus')
    //             ->modalIcon('heroicon-o-plus')

    //             ->label('Object toevoegen'),
    //     ];
    // }
    public function getHeading(): string
    {
        return "Object - Overzicht";
    }
}
