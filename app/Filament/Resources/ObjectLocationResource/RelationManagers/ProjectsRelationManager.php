<?php
namespace App\Filament\Resources\ObjectLocationResource\RelationManagers;

use App\Models\Project;
use App\Models\Statuses;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ProjectsRelationManager extends RelationManager
{
    protected static string $relationship = 'projects';
    protected static bool $isLazy         = false;
    protected static ?string $icon        = 'heroicon-o-archive-box';
    protected static ?string $title       = 'Projecten';

    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        // $ownerModel is of actual type Job
        return $ownerRecord->projects->count();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make()
                    ->schema([
                        Grid::make([
                            "default" => 2,
                            "sm"      => 2,
                            "md"      => 2,
                            "lg"      => 2,
                            "xl"      => 2,
                            "2xl"     => 2,
                        ])->schema([
                            Forms\Components\TextInput::make("name")
                                ->label("Omschrijving")
                                ->maxLength(255)
                                ->required()
                                ->columnSpan("full"),

                            TextInput::make("description")
                                ->label("Opmerking")
                                ->columnSpan("full"),
                        ]),
                    ])
                    ->columnSpan(["lg" => 2]),

                Section::make()
                    ->schema([
                        Grid::make([
                            "default" => 2,
                            "sm"      => 2,
                            "md"      => 2,
                            "lg"      => 2,
                            "xl"      => 2,
                            "2xl"     => 2,
                        ])->schema([
                            DatePicker::make("requestdate")->label(
                                "Aanvraagdatum"
                            ),

                            DatePicker::make("date_of_execution")
                                ->label("Plandatum")
                                ->placeholder('Onbekend'),

                            DatePicker::make("startdate")->label("Startdatum"),
                            DatePicker::make("enddate")->label("Einddatum"),
                        ]),
                    ])
                    ->columnSpan(["lg" => 2]),

                Section::make()
                    ->schema([
                        Grid::make([
                            "default" => 2,
                            "sm"      => 2,
                            "md"      => 2,
                            "lg"      => 2,
                            "xl"      => 2,
                            "2xl"     => 2,
                        ])->schema(
                            components: [
                                TextInput::make("budget_costs")
                                    ->label("Budget")
                                    ->suffixIcon("heroicon-o-currency-euro")
                                    ->columnSpan("full"),

                                Select::make("status_id")
                                    ->label("Status")
                                    ->required()
                                    ->reactive()
                                    ->options(
                                        Statuses::where(
                                            "model",
                                            "Project"
                                        )->pluck("name", "id")
                                    )->columnSpan("full"),
                            ]
                        ),
                    ])->columnSpan(2),

            ])
            ->columns(6);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([

                Tables\Columns\TextColumn::make('id')
                    ->label('#')
                    ->getStateUsing(function (Project $record): ?string {
                        return sprintf('%05d', $record?->id);
                    })
                    ->sortable()->description(function (Project $record) {

                    if (! $record?->description) {
                        return false;
                    } else {
                        return $record->description;
                    }

                }),

                Tables\Columns\TextColumn::make('name')
                    ->label('Omschrijving')
                    ->wrap(),

                Tables\Columns\TextColumn::make('startdate')
                    ->label('Looptijd')
                    ->getStateUsing(function (Project $record): ?string {

                        $startdate = $record->startdate ? date("d-m-Y", strtotime($record?->startdate)) : "nodate";
                        $enddate   = $record->enddate ? date("d-m-Y", strtotime($record?->enddate)) : "nodate";

                        if ($record->enddate || $record->$startdate) {
                            return $startdate . " - " . $enddate;
                        } else {
                            return "";
                        }

                    })
                    ->placeholder('Geen looptijd'),

//                Tables\Columns\TextColumn::make('description')
//                    ->label('Omschrijving')
//                    ->weight(FontWeight::Light)
//                    ->sortable()->wrap(),

                Tables\Columns\TextColumn::make('date_of_execution')
                    ->label('Plandatum')
                    ->getStateUsing(function (Project $record): ?string {

                        if ($record->date_of_execution) {
                            return date("d-m-Y", strtotime($record?->date_of_execution));
                        } else {
                            return "-";
                        }

                    })
                    ->color(fn($record) => strtotime($record?->date_of_execution) < time() ? 'danger' : 'success')

                ,

//                Tables\Columns\TextColumn::make('cost_price')
//                    ->label('Winst')
//                    ->getStateUsing(function (Project $record): ?string {
//                        return $record?->quote_price - $record?->cost_price;
//                    })->prefix('€')
//                    ->color(fn($record) => $record?->quote_price - $record?->cost_price < 0 ? 'danger' : 'success')
//                    ->badge()->sortable()
//                    ->icon(fn($record) => $record?->quote_price - $record?->cost_price < 0 ? 'heroicon-m-exclamation-triangle' : false),

//                Tables\Columns\TextColumn::make('budget_costs')
//                    ->label('Over')
//                    ->getStateUsing(function (Project $record): ?string {
//                        $total_price = $record?->budget_costs - ($record?->quote_price - $record?->cost_price);
//                        return $total_price;
//                    })->prefix('€'),

                Tables\Columns\TextColumn::make('status.name')
                    ->label('Status')->sortable()
                    ->badge(),
            ])->emptyState(view('partials.empty-state-small'))
            ->filters([
                //
            ])
            ->headerActions([

                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['customer_id'] = $this->getOwnerRecord()->customer_id;

                        return $data;
                    })
                    ->modalWidth(MaxWidth::SevenExtraLarge),

            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Open project')->url(function (Project $record) {
                    return "/app/projects/" . $record->id . "/edit";

                })->icon('heroicon-c-link'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
