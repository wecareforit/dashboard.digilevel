<?php
namespace App\Filament\Widgets;

use App\Models\Elevator;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class StandStill extends BaseWidget
{
    protected static ?int $sort                = 12;
    protected static ?string $heading          = "Stilstaande liften";
    protected int|string|array $columnSpan = '6';
    protected static ?string $maxHeight        = '300px';
    protected static bool $isLazy              = false;

    public static function canView(): bool
    {
       return setting('module_elevators') ?? false;
    }


    public function table(Table $table): Table
    {
        $status_id = null;
        return $table
            ->query(
                Elevator::has("incident_stand_still")->latest()
                    ->limit(10))
            ->columns([
                Tables\Columns\TextColumn::make("location")
                    ->getStateUsing(function (Elevator $record): ?string {
                        if ($record?->location?->name) {
                            return $record?->location?->name;
                        } else {
                            return $record?->location?->address .
                            " - " .
                            $record?->location?->zipcode .
                            " " .
                            $record?->location?->place;
                        }
                    })
                    ->label("Locatie"),

                Tables\Columns\TextColumn::make("location.customer.name")
                    ->label("Relatie"),

                Tables\Columns\TextColumn::make("unit_no")
                    ->label("Unit nummer")
                    ->placeholder("Geen unitnummer"),
            ])
            ->emptyState(view("partials.empty-state"))
            ->recordUrl(function (Elevator $record) {
                return "/objects/" . $record->id . "?activeRelationManager=1";
            })
            ->paginated(false)
            ->headerActions([
                Action::make('viewAllObjects')
                    ->label('Bekijk alle stilstaande liften')
                    ->url(fn() => '/objects')
                    ->button()
                    ->link()
                    ->color('primary'),
            ]);
    }
}
