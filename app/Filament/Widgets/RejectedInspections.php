<?php
namespace App\Filament\Widgets;

use App\Enums\InspectionStatus;
use App\Models\Elevator;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RejectedInspections extends BaseWidget
{
    protected static ?int $sort                = 80;
    protected static ?string $heading          = "Afgekeurde objecten";
    protected int|string|array $columnSpan = '6';
    protected static bool $isLazy              = false;
    protected static ?string $maxHeight        = '600px';

    public static function canView(): bool
    {
       return setting('module_elevators') ?? false;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Elevator::whereYear('current_inspection_end_date', date('Y'))
                    ->where('current_inspection_status_id', InspectionStatus::REJECTED)
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make("location")
                    ->getStateUsing(function (Elevator $record): ?string {
                        if ($record?->location?->name) {
                            return $record?->location?->name;
                        } else {
                            return $record->location?->address .
                            " - " .
                            $record->location->zipcode .
                            " " .
                            $record->location->place;
                        }
                    })
                    ->label("Locatie")
                    ->description(function (Elevator $record) {
                        if (! $record?->location?->name) {
                            return $record?->location?->name;
                        } else {
                            return $record->location?->address .
                            " - " .
                            $record->location->zipcode .
                            " " .
                            $record->location->place;
                        }
                    }),

                Tables\Columns\TextColumn::make("latestInspection.end_date")
                    ->label("Verlopen op")
                    ->dateTime("d-m-Y"),

                Tables\Columns\TextColumn::make("location.customer.name")
                    ->label("Relatie")
                    ->url(function (object $record) {
                        return "/relation/" . $record->customer_id . "";
                    })
                    ->icon("heroicon-c-link")
                    ->placeholder("Niet opgegeven"),
            ])
            ->emptyState(view("partials.empty-state"))
            ->recordUrl(function (Elevator $record) {
                return "/elevators/" . $record->id . "?activeRelationManager=1";
            })
            ->paginated(false)
            ->headerActions([
                Action::make('viewAllRejectedInspections')
                    ->label('Bekijk alle afgekeurde objecten')
                    ->url(fn() => '/elevators?filter[current_inspection_status_id]=' . InspectionStatus::REJECTED->value) // Adjust the URL as needed
                    ->button()
                    ->link()
                    ->color('primary'),
            ]);
    }
}
