<?php
namespace App\Filament\Resources;

use App\Enums\Priority;
use App\Filament\Resources\TicketResource\Pages;
use App\Filament\Resources\TicketResource\RelationManagers;
use App\Models\Department;
use App\Models\Location;
use App\Models\Relation;
use App\Models\Ticket;
use App\Enums\ticketStatus;
use App\Enums\TicketTypes;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Infolists\Components;
use Filament\Infolists\Infolist;
use Filament\Resources\RelationManagers\RelationGroup;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use LaraZeus\Tiles\Tables\Columns\TileColumn;

class TicketResource extends Resource
{

    protected static ?string $model            = Ticket::class;
    protected $listeners                       = ["refresh" => '$refresh'];
    protected static ?string $navigationIcon   = 'heroicon-o-queue-list';
    protected static ?string $navigationLabel  = 'Tickets';
    protected static ?string $pluralModelLabel = 'Tickets';
    protected static ?string $title            = 'Tickets';

    public static function shouldRegisterNavigation(): bool
    {
        return setting('use_tickets') ?? false;
    }

    public static function form(Form $form): Form
    {

        return $form
            ->schema([
                Section::make()
                    ->schema([

                        Forms\Components\Select::make('created_by_user')
                            ->options(function (callable $get) {
                                $companyId = $get('relation_id'); // or use $get('record.company_id') if editing
                                return \App\Models\Contact::query()
                                    ->where('relation_id', $companyId)
                                    ->get()
                                    ->mapWithKeys(fn($employee) => [
                                        $employee->id => "{$employee->first_name} {$employee->last_name}",
                                    ]);

                            })

                            ->preload()

                            ->label('Contactpersoon')

                            ->columnSpan(2)
                        ,

                        Forms\Components\Select::make('status_id')
                            ->default('1')
                            ->label('Status')
                            ->options(ticketStatus::class),
                        Forms\Components\Select::make('type')
                            ->label('Type')
                            ->default('2')
                            ->options(TicketTypes::class),

                        ToggleButtons::make('priority')
                            ->options(Priority::class)

                          
                            ->default(3)->grouped()
                            ->label('Prioriteit'),

                    ])->columns(3),

                Section::make()
                    ->schema([
                        Forms\Components\Select::make('department_id')
                            ->label('Afdeling toewijzing')

                            ->options(Department::pluck('name', 'id'))

                            ->createOptionForm([

                                Grid::make(2)
                                    ->schema([

                                        Forms\Components\TextInput::make('name')
                                            ->label('Afdelingsnaam')
                                            ->required(),

                                        Forms\Components\Select::make("location_id")
                                            ->label("Locatie")
                                            ->required()
                                            ->options(
                                                Location::pluck("name", "id")
                                            ),

                                    ]),

                            ])

                            ->createOptionUsing(function (array $data): int {

                                return Department::create($data)->getKey();
                            }),

                        Forms\Components\Select::make('assigned_by_user')
                            ->label('Medewerker')

                            ->options(User::pluck('name', 'id'))
                            ->searchable()
                            ->default(Auth::id())
                            ->label('Medewerker')

                            ->options(
                                User::get()
                                    ->mapWithKeys(fn($employee) => [
                                        $employee->id => "{$employee->name}",
                                    ])
                            ),
                    ])
                    ->columns(3),

                Section::make('Ticket omschrijving')
                    ->description('Zoals een foutmelding of aanvraag voor veranderingen')
                    ->schema([

                        Textarea::make('description')->label('Omschrijving')->columnSpan('full')
                            ->required()->rows(10),
                    ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            \Filament\Infolists\Components\Section::make()

                ->schema([

                    Components\TextEntry::make('relation.name')
                        ->label("Relatie")
                        ->placeholder("Niet opgegeven")

                        ->Url(function (object $record) {
                            return "/relations/" . $record->relation_id . "";
                        })
                        ->icon("heroicon-c-link"),

                    Components\TextEntry::make('type.name')
                        ->label("Type")
                        ->badge()
                        ->placeholder("Niet opgegeven"),

                    Components\TextEntry::make('status_id')
                        ->label("Status")
                        ->badge()
                        ->placeholder("Niet opgegeven"),

                    // TileEntry::make('AssignedByUser.name')
                    //     ->columnSpanFull()
                    //     ->label('Toegvoegd door')
                    //     ->description(fn($record) => $record->AssignedByUser->email)
                    //     ->image(fn($record) => $record?->AssignedByUser?->avatar),

                    // TileEntry::make('AssignedByUser.name')
                    //     ->columnSpanFull()
                    //     ->label('Gemaakt door')
                    //     ->description(fn($record) => $record->createByUser->email)
                    //     ->image(fn($record) => $record?->createByUser?->avatar),

                    Components\TextEntry::make('createByUser.name')
                        ->label("Aangemaak door")
                        ->badge()
                        ->placeholder("Niet toegewezen"),

                    Components\TextEntry::make('created_at')
                        ->label("Aangemaakt op")
                        ->Date('d-m-Y H:i')
                        ->placeholder("Niet toegewezen"),

                    Components\TextEntry::make('priority')
                        ->label("Prioriteit")
                        ->badge()
                        ->placeholder("Niet opgegeven"),
                    Components\TextEntry::make('AssignedByUser.name')
                        ->label("Medewerker")
                        ->badge()
                        ->placeholder("Niet toegewezen"),

                    Components\TextEntry::make('department.name')
                        ->label("Afdeling")
                        ->placeholder("Niet opgegeven"),
                ])->columns(5),

            // \Filament\Infolists\Components\Section::make('Object gegevens')

            //     ->schema([

            //         Components\TextEntry::make('object.name')
            //             ->label("Naam")
            //             ->placeholder("Niet opgegeven")
            //             ->Url(function (object $record) {
            //                 return "/objects/" . $record->asset_id . "";
            //             })
            //             ->icon("heroicon-c-link"),

            //         Components\TextEntry::make('object.type.name')
            //             ->label("Type")
            //             ->badge()
            //             ->placeholder("Niet opgegeven")
            //         ,

            //         Components\TextEntry::make('object.brand.name')
            //             ->label("Merk")
            //             ->placeholder("Niet opgegeven")
            //         ,

            //         Components\TextEntry::make('object.model.name')
            //             ->label("Type")
            //             ->placeholder("Niet opgegeven")
            //         ,

            //         Components\TextEntry::make('object.serial_number')
            //             ->label("Serienummer")
            //             ->placeholder("Niet opgegeven"),

            //     ])->columns(5),

            \Filament\Infolists\Components\Section::make('Ticket omschrijving')
                ->schema([
                    // ...

                    Components\TextEntry::make('description')
                        ->hiddenLabel()
                        ->placeholder("Geen opmerking"),
                ]),
        ]);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['id', 'relation.name', 'description'];
    }

    public static function getGlobalSearchResultDetails($record): array
    {

        return [
            'Nummer'  => sprintf("%05d", $record?->id),
            'Relatie' => $record?->relation?->name ?? "Onbekend",
        ];

    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'decs')
            ->persistSortInSession()
            ->persistSearchInSession()
            ->searchable()
            ->persistColumnSearchesInSession()
            ->recordClasses(fn($record) =>
                $record->deleted_at ? 'table_row_deleted ' : null
            )

            ->columns([

                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->grow(false)
                    ->toggleable()
                    ->label('#')
                    ->getStateUsing(function ($record): ?string {
                        return sprintf("%05d", $record?->id);
                    }),
                //     ->label('Medewerker'),
                Tables\Columns\TextColumn::make(priority::class)
                    ->badge()
                    ->sortable()
                    ->grow(false)
                    ->toggleable()
                    ->label('Prioriteit'),

                //     ->label('Medewerker'),
                Tables\Columns\TextColumn::make('status_id')
                    ->badge()
                    ->sortable()
                    ->toggleable()
                    ->label('Status'),
                Tables\Columns\TextColumn::make('department.name')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable()
                    ->toggleable()
                    ->badge()
                    ->placeholder('Algemeen')
                    ->label('Afdeling'),
                Tables\Columns\TextColumn::make('type.name')
                    ->badge()
                    ->sortable()
                    ->toggleable()
                    ->placeholder('Algemeen')
                    ->label('Type'),
                Tables\Columns\TextColumn::make('description')
                    ->limit(50)
                    ->toggleable()
                    ->wrap()
                    ->lineClamp(2)
                    ->label('Omschrijving'),
                TileColumn::make('AssignedByUser')
                // ->description(fn($record) => $record->AssignedByUser->email)
                    ->sortable()
                    ->getStateUsing(function ($record): ?string {
                        return $record?->AssignedByUser?->name;
                    })
                //     ->description(fn($record) => $record->AssignedByUser?->email)
                    ->label('Toegewezen medewerker')
                    ->image(fn($record) => $record?->AssignedByUser?->avatar)
                    ->placeholder('Geen'),

                Tables\Columns\TextColumn::make('created_at')
                    ->getStateUsing(function ($record): ?string {
                        return $record?->createByUser?->name;
                    })

                    ->description(function ($record): ?string {
                        return date("d-m-Y H m:s", strtotime($record?->created_at));
                    })
                    ->label('Gemeld')
                    ->placeholder('Niet opgegeven')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('relation.name')
                    ->sortable()
                    ->url(function ($record) {
                        return "relations/" . $record->relation_id;
                    })
                    ->toggleable()
                    ->label('Relatie'),

                // Tables\Columns\TextColumn::make('AssignedByUser.name')
                //     ->sortable()
                //     ->toggleable()
                //     ->label('Medewerker'),

            ])
            ->filters([
                SelectFilter::make('relation_id')
                    ->label('Relatie')

                    ->options(Relation::all()->pluck("name", "id")),
                SelectFilter::make('assigned_by_user')
                    ->label('Medewerker')
                    ->options(User::all()->pluck("name", "id")),

                SelectFilter::make('status_id')
                    ->label('Status')
                    ->options(TicketStatus::class),
                SelectFilter::make('type_id')
                    ->label('Type')
                    ->options(TicketTypes::class),

                SelectFilter::make('department_id')
                    ->label('Afdeling')
                    ->options(Department::pluck('name', 'id')),

                TernaryFilter::make('statsu_id')
                    ->label('Gesloten tickets')
                    ->placeholder('Alle tickets')
                    ->trueLabel('Verbergen')
                    ->falseLabel('Tonen')
                    ->queries(
                        true: fn(Builder $query)  => $query->whereNot('status_id', 7),
                        false: fn(Builder $query) => $query->where('status_id', 7),
                        blank: fn(Builder $query) => $query, // In this example, we do not want to filter the query when it is blank.
                    ),
                // ->default(1)

                TrashedFilter::make(),

            ], layout: FiltersLayout::Modal)
            ->filtersFormColumns(4)
            ->actions([

                // Tables\Actions\EditAction::make('editTicket')
                //     ->label('Snel bewerken')
                //     ->icon('heroicon-s-pencil')
                // ,

                Tables\Actions\ViewAction::make('openLocation')
                    ->label('Bekijk')
                    ->url(fn($record): string => route('filament.app.resources.tickets.view', ['record' => $record]))
                    ->icon('heroicon-s-eye'),
                RestoreAction::make()
                    ->color("danger")
                    ->modalHeading('Actie terug plaatsen')
                    ->modalDescription(
                        "Weet je zeker dat je deze actie wilt activeren"
                    ),
                //     Tables\Actions\ActionGroup::make([

                // DeleteAction::make()
                //     ->modalIcon('heroicon-o-trash')
                //     ->tooltip('Verwijderen')
                //     ->modalHeading('Verwijderen')
                //     ->color('danger'),
                // Tables\Actions\EditAction::make(),

                // ]),

            ])->recordUrl(
            fn($record): string => route('filament.app.resources.tickets.view', ['record' => $record])
        )
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ])->emptyState(view("partials.empty-state"));
    }

    public static function getRelations(): array
    {
        return [
            RelationGroup::make('', [
                RelationManagers\ObjectsRelationManager::class,
                RelationManagers\TimeTrackingRelationManager::class,
            ]),
        ];
    }

    public static function getModelLabel(): string
    {
        return 'Ticket';
    }
    public static function getPluralModelLabel(): string
    {
        return 'Tickets';
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            //    'edit'   => Pages\EditTicket::route('/{record}/edit'),
            'view'   => Pages\ViewTicket::route('/{record}'),
        ];
    }

}
