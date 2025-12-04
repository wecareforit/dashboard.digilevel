<?php
namespace App\Filament\Resources\ElevatorResource\Pages;

use App\Filament\Resources\ElevatorResource;
use Filament\Resources\Pages\ListRecords;
use Relaticle\CustomFields\Filament\Tables\Concerns\InteractsWithCustomFields;
use Asmit\ResizedColumn\HasResizableColumn;
class ListElevators extends ListRecords
{
    protected static string $resource = ElevatorResource::class;
    use InteractsWithCustomFields;
    protected static ?string $title = 'Objecten';
    use HasResizableColumn;
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
