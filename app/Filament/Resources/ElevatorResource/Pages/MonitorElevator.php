<?php
namespace App\Filament\Resources\ElevatorResource\Pages;

use App\Filament\Resources\ElevatorResource;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;

class MonitorElevator extends Page
{
    protected static string $resource = ElevatorResource::class;

    protected static string $view = 'filament.resources.object-resource.pages.monitor-object';

    use InteractsWithRecord;

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ElevatorResource\Widgets\ElevatorResourceg::class,
            ElevatorResource\Widgets\ElevatorResourcegStopsenDoors::class,

            ElevatorResource\Widgets\ElevatorResourcegIncidentChart::class,
            //     ElevatorResource\Widgets\ElevatorResourcegLevelChar::class,

            ElevatorResource\Widgets\ElevatorResourcegEventsTable::class,

            // ElevatorResource\Widgets\DirectionChart::class,
        ];
    }

    public function getHeaderWidgetsColumns(): int | array
    {
        return 8;
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Terug')
                ->url(fn() => ElevatorResource::getUrl('view', ['record' => $this->record]))
                ->color('secondary'),
        ];
    }

    public function getSubheading(): ?string
    {
        if ($this->getRecord()->location) {
            $location_name = null;
            if ($this->getRecord()->location?->name) {
                $location_name = " | " . $this->getRecord()->location?->name;
            }
            return $this->getRecord()->location->address . " " . $this->getRecord()->location->zipcode . " " . $this->getRecord()->location->place . $location_name;
        } else {
            return "";
        }
    }
}
