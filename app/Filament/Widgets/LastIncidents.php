<?php
namespace App\Filament\Widgets;

use App\Models\ObjectIncident;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LastIncidents extends BaseWidget
{
    protected static ?int $sort                = 15;
    protected int|string|array $columnSpan = '6';
    protected static ?string $maxHeight        = '300px';
    protected static ?string $heading          = "Laatste storingen";
    protected static bool $isLazy              = false;

    public function table(Table $table): Table
    {
        return $table
            ->query(ObjectIncident::orderby('created_at', 'desc')->limit(10))
            ->columns([
                Tables\Columns\TextColumn::make("report_date_time")
                    ->label("Gemeld op ")
                    ->sortable()
                    ->date('d-m-Y H:i')
                    ->wrap(),

                Tables\Columns\TextColumn::make("description")
                    ->label("Omschrijving")
                    ->sortable()
                    ->wrap(),

                Tables\Columns\TextColumn::make("status_id")
                    ->label("Status")
                    ->sortable()
                    ->badge(),

                Tables\Columns\TextColumn::make("type_id")
                    ->label("Type")
                    ->badge(),
            ])
            ->emptyState(view("partials.empty-state"))
            ->recordUrl(function (ObjectIncident $record) {
                return "/objects/" . $record->id . "?activeRelationManager=1";
            })
            ->paginated(false)
            ->headerActions([
                Action::make('viewAllIncidents')
                    ->label('Bekijk alle storingen')
                    ->url(fn() => '/incidents') // Adjust the URL as needed
                    ->button()
                    ->link()
                    ->color('primary'),
            ]);
    }
}
