<?php
namespace App\Filament\Resources\ElevatorResource\RelationManagers;

use App\Enums\IncidentStatus;
use App\Enums\IncidentTypes;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class TicketsRelationManager extends RelationManager
{
    protected static string $relationship = 'Incidents';
    protected static ?string $title       = 'Storingen';
    protected static bool $isLazy         = false;

    public static function getBadge($ownerRecord, string $pageClass): ?string
    {
        return $ownerRecord
            ->incidents
            ->count();
    }

    // public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    // {

    //     return in_array('Tickets', $ownerRecord?->type?->options) ? true : false;
    // }

    public function form(Form $form): Form
    {
        return $form->schema([

            Grid::make(['default' => 3,

            ])->schema([

                DateTimePicker::make('report_date_time')
                    ->required()
                    ->label('Melddatum & tijd')
                    ->default(now()),

                Select::make('type_id')
                    ->options(IncidentTypes::class)
                    ->default('4')
                    ->native(false)
                    ->label('Type'),

                Select::make('priority_id')
                    ->options(['1' => 'Hoog', '2' => 'Gemiddeld', '3' => 'Laag', '0' => 'Geen',

                    ])
                    ->label('Prioriteit')
                    ->default('2')
                    ->native(false),

                Select::make('status_id')
                    ->label('Status')
                    ->options(IncidentStatus::class)
                    ->default(1)
                    ->native(false),

                Forms\Components\Textarea::make('description')
                    ->required()
                    ->rows(10)
                    ->label('Storingsomschrijving')
                    ->maxLength(255)
                    ->columnSpan('3'),

                Checkbox::make('standing_still')
                    ->label('Door deze storing is de lift buiten bedrijf')
                    ->columnSpan('3')])]);
    }

    public function table(Table $table):
    Table {
        return $table->recordTitleAttribute('name')->columns([

            Tables\Columns\TextColumn::make("id")
                ->label("#")
                ->getStateUsing(function ($record): ?string {
                    return sprintf("%05d", $record?->id);
                }),

            Tables\Columns\TextColumn::make("standing_still")
                ->label('')
                ->getStateUsing(function ($record): ?string {
                    if ($record->standing_still == "1") {
                        return "Stilstand";
                    } else {
                        return null;
                    }
                })

                ->color('danger')
                ->badge()
            ,

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
            ->filters([

            ])
            ->paginated(false)
            ->emptyState(view('partials.empty-state-small'))
            ->headerActions([Tables\Actions\CreateAction::make()

                //     ->mutateFormDataUsing(function (array $data): array {
                //    dd($data['standing_still']);

                //         Elevator::where('id', $this->ownerRecord->id)
                //         ->update(['standing_still' => $data->standing_still]);

                //     })

                    ->label('Toevoegen')])->actions([Tables\Actions\Action::make('seeDetails')
                ->label('Toon details')
                ->color('success')
                ->icon('heroicon-m-eye')->url(function ($record) {
                return "/app/object-inspections/" . $record->id;
            }),

        ])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([
            ]), ]);
    }

}
