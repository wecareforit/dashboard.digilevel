<?php
namespace App\Filament\Resources\TimeTrackingResource\Pages;

use App\Filament\Resources\TimeTrackingResource;
use App\Models\timeTracking;
use Asmit\ResizedColumn\HasResizableColumn;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Database\Eloquent\Builder;
use Relaticle\CustomFields\Filament\Tables\Concerns\InteractsWithCustomFields;

class ListTimeTrackings extends ListRecords
{
    use InteractsWithCustomFields;
    protected static string $resource = TimeTrackingResource::class;
    use HasResizableColumn;
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->modalWidth(MaxWidth::FourExtraLarge)
                ->modalHeading('Registratie toevoegen')
                ->modalDescription('Voeg een nieuwe registratie toe door de onderstaande gegeven zo volledig mogelijk in te vullen.')
                ->icon('heroicon-m-plus')
                ->modalIcon('heroicon-o-plus')

                ->label('Registratie toevoegen'),

        ];
    }
    public function getHeading(): string
    {
        return "Tijdregistratie - Overzicht";
    }

    protected function getHeaderWidgets(): array
    {

        return [
            // ObjectResource\Widgets\Monitoring::class,
            //     TimeTrackingResource\Widgets\StatsOverview::class,

        ];

    }

    public function getTabs(): array
    {
        return [
            'Alle'          => Tab::make(),
            'Geregistreerd' => Tab::make()
                ->ModifyQueryUsing(fn(Builder $query) => $query->where('status_id', 2))
                ->badge(timeTracking::query()->where('status_id', 2)->count()),
            'Gefactureerd'  => Tab::make()
                ->ModifyQueryUsing(fn(Builder $query) => $query->where('status_id', 1))
                ->badge(timeTracking::query()->where('status_id', 1)->count()),
            'Afgeschreven'  => Tab::make()
                ->ModifyQueryUsing(fn(Builder $query) => $query->where('status_id', 3))
                ->badge(timeTracking::query()->where('status_id', 3)->count()),
        ];
    }

}
