<?php
namespace App\Filament\Resources\ElevatorResource\Pages;

use App\Filament\Resources\ElevatorResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Parallax\FilamentComments\Actions\CommentsAction;

class ViewElevator extends ViewRecord
{
    protected static string $resource = ElevatorResource::class;
    protected static ?string $title   = 'Objecten eigenschappen';

    public function getSubheading(): ?string
    {

        if ($this->getRecord()->monitoring_object_id) {

            return "Monitoring: " . ucfirst($this?->getRecord()?->getMonitoringVersion?->brand) . " - " . $this->getRecord()?->getMonitoringVersion?->value . " " . $this->getRecord()?->getMonitoringType?->value . " " . $this->getRecord()?->getMonitoringStateText();

        } else {
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
    public function getHeaderWidgetsColumns(): int | array
    {
        return 8;
    }
    protected function getHeaderWidgets(): array
    {

        if ($this->getRecord()->monitoring_object_id) {
            return [
                // ElevatorResource\Widgets\Monitoring::class,
                ElevatorResource\Widgets\MonitoringStopsenDoors::class,
                ElevatorResource\Widgets\MonitoringIncidentChart::class,
            ];
        } else {
            return [];
        }
    }
    protected function getHeaderActions(): array
    {

        if ($this->getRecord()->monitoring_object_id) {
            return [

                Action::make('back')

                    ->label('Terug naar overzicht')
                    ->link()
                    ->url('/objects')
                    ->color('gray'),

                Actions\Action::make('cancel_top')
                    ->iconButton()
                    ->color('gray')
                    ->label('Uitgebreide monitoring')
                    ->link()
                    ->url(function ($record) {
                        return $this->getRecord()?->id . "/monitoring";
                    }),

                Actions\Action::make('cancel_top')
                    ->iconButton()
                    ->color('gray')
                    ->label('Open locatie')
                    ->link()
                    ->icon('heroicon-s-map-pin')
                    ->url(function ($record) {
                        return "/object-locations/" . $this->getRecord()?->location?->id;
                    }),

                Actions\EditAction::make('cancel_top')

                    ->icon('heroicon-m-pencil-square')
                    ->label('Wijzig'),

            ];
        } else {
            return [

                Action::make('back')

                    ->label('Terug naar overzicht')
                    ->link()
                    ->url('/relations')
                    ->color('gray'),
                Actions\Action::make('cancel_top')
                    ->iconButton()
                    ->color('gray')
                    ->label('Open locatie')
                    ->link()
                    ->icon('heroicon-s-map-pin')
                    ->url(function ($record) {
                        return "/object-locations/" . $this->getRecord()?->location?->id;
                    }),

                Actions\EditAction::make('cancel_top')

                    ->icon('heroicon-m-pencil-square')
                    ->slideOver()
                    ->label('Wijzig'),

                CommentsAction::make(),

            ];
        }

    }

}
