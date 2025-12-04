<?php
namespace App\Filament\Resources\RelationResource\RelationManagers;

use App\Models\Statuses;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ProjectsRelationManager extends RelationManager
{
    protected static ?string $icon        = "heroicon-o-archive-box";
    protected static string $relationship = 'Projects';
    protected static ?string $title       = 'Projecten';

    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        return $ownerRecord->Projects()->count();
    }

    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {

        return in_array('Projecten', $ownerRecord?->type->options) ? true : false;
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

                // Section::make()
                //     ->schema([
                //         Select::make("location_id")
                //             ->searchable()
                //             ->label("Locatie")
                //             ->columnSpan("full")
                //             ->options(ObjectLocation::where('customer_id', $this->getOwnerRecord()->id)->pluck("address", "id")),
                //     ])
                //     ->columns(2)
                //     ->columnSpan(1),

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
                            DatePicker::make("requestdate")->label("Aanvraagdatum"),
                            DatePicker::make("date_of_execution")
                                ->label("Plandatum")
                                ->placeholder('Onbekend'),
                            DatePicker::make("startdate")->label("Startdatum"),
                            DatePicker::make("enddate")->label("Einddatum"),
                        ]),
                    ]),

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
                            TextInput::make("budget_costs")
                                ->label("Budget")
                                ->suffixIcon("heroicon-o-currency-euro")
                                ->columnSpan("full"),
                            Select::make("status_id")
                                ->label("Status")
                                ->reactive()
                                ->options(["1" => "Open"])
                                ->columnSpan("full")
                                ->default(1),
                        ]),
                    ])->columnSpan(1),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table

            ->columns([
                Tables\Columns\TextColumn::make("id")
                    ->label("#")
                    ->getStateUsing(function ($record): ?string {
                        return sprintf("%05d", $record?->id);
                    })
                    ->searchable()
                    ->sortable()
                    ->wrap()
                ,

                Tables\Columns\TextColumn::make("name")
                    ->label("Omschrijving")
                    ->searchable()
                    ->wrap()
                    ->description(function ($record) {
                        if (! $record?->description) {
                            return false;
                        } else {
                            return $record->description;
                        }
                    })
                ,

                Tables\Columns\TextColumn::make("location")
                    ->getStateUsing(function ($record): ?string {
                        return $record?->location?->address . "-" . $record?->location?->zipcode . " - " . $record?->location?->place;
                    })
                    ->label("Locatie")
                    ->placeholder('Geen')
                    ->url(function ($record) {
                        return "/relation-locations/" . $record->location_id;
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make("status.name")
                    ->label("Status")
                    ->placeholder('Onbekend')
                    ->sortable()
                    ->badge(),
            ])->recordUrl(
            fn($record): string => route('filament.app.resources.projects.view', ['record' => $record])
        )
         
            ->filters([
                SelectFilter::make("status_id")
                    ->label("Status")
                    ->options(Statuses::where("model", "Project")->pluck("name", "id"))
                    ->searchable()
                    ->preload(),

            ])
            ->actions([

                Action::make('openproject')
                    ->label('Meer informatie')
                    ->url(function ($record) {
                        return "/projects/" . $record->id;
                    })->icon('heroicon-s-eye'),

            ])

            ->emptyState(view("partials.empty-state"));

    }

}
