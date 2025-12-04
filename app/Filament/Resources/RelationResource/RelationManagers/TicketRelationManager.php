<?php
namespace App\Filament\Resources\RelationResource\RelationManagers;

use App\Enums\Priority;
use App\Models\Department;
use App\Models\Contact;
use App\Models\Location;
 
use App\Enums\TicketTypes;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use LaraZeus\Tiles\Tables\Columns\TileColumn;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Enums\TicketStatus;
use Filament\Tables\Filters\Filter;


class TicketRelationManager extends RelationManager
{
    protected static string $relationship = 'tickets';

    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        return $ownerRecord->tickets->count();
    }

    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        if (! $ownerRecord->type) {
            return false;
        }

        $options = $ownerRecord->type->options ?? [];
        return in_array('Tickets', (array) $options);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Forms\Components\Select::make('created_by_user')
                            ->searchable(['first_name', 'last_name', 'email'])
                            ->options(function (callable $get) {
                                $contacts = Contact::query()
                                    ->where('relation_id', $this->getOwnerRecord()->id)
                                    ->orderBy('type_id')
                                    ->orderBy('first_name')
                                    ->get();

                                return $contacts
                                    ->groupBy('type_id')
                                    ->mapWithKeys(function ($group, $typeId) {
                                        $label = match ($typeId) {
                                            2 => 'Contactpersoon',
                                            1 => 'Medewerker',
                                            default => 'Overig',
                                        };
                                        return [
                                            $label => $group->mapWithKeys(fn ($employee) => [
                                                $employee->id => "{$employee->first_name} {$employee->last_name}",
                                            ]),
                                        ];
                                    })
                                    ->toArray();
                            })
                            ->createOptionForm([
                                Grid::make(4)
                                    ->schema([
                                        
                          Forms\Components\Select::make('type_id')
                            ->options([
                                '2' => 'Contactpersoon',
                                '1' => 'Medewerker',
                            ])
            
                            ->label('Type'),
                                        Forms\Components\TextInput::make('first_name')
                                            ->label('Voornaam')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('last_name')
                                            ->columnSpan('2')
                                            ->label('Achternaam')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('email')
                                            ->columnSpan(2)
                                            ->label('E-mailadres')
                                            ->email()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('department')
                                            ->label('Afdeling')
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('phone_number')
                                            ->label('Telefoonnummer')
                                            ->maxLength(255),
                                        Forms\Components\Toggle::make('show_in_contactlist')
                                            ->label('Toon in contactpersonen overzicht')
                                            ->columnSpan('full')


                                    ]),
                            ])
                            ->createOptionUsing(function (array $data): int {
                                $data['relation_id'] = $this->ownerRecord->id;
                                return Contact::create($data)->getKey();
                            })
                            ->label('Melder')
                            ->columnSpan(2),

              Forms\Components\Select::make('status_id')
                            ->default('1')
                            ->label('Status')
                            ->options(ticketStatus::class),
                        Forms\Components\Select::make('type')
                            ->label('Type')
                              ->default(TicketTypes::INCIDENT) 
                            ->options(TicketTypes::class),

                        ToggleButtons::make('priority')
                            ->required()
                            ->options(Priority::class)
                            ->default(Priority::LOW->value)
                            ->grouped()
                            ->label('Prioriteit'),
                    ])
                    ->columns(3),

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
                                            ->options(Location::pluck("name", "id")),
                                    ]),
                            ])
                            ->createOptionUsing(function (array $data): int {
                                return Department::create($data)->getKey();
                            }),

                        Forms\Components\Select::make('assigned_by_user')
                            ->label('Medewerker')
                            ->options(User::get()
                                ->mapWithKeys(fn($employee) => [
                                    $employee->id => "{$employee->name}",
                                ])
                            )
                            ->searchable()
                            ->default(Auth::id()),
                    ])
                    ->columns(3),

                Section::make('Ticket omschrijving')
                    ->description('Zoals een foutmelding of aanvraag voor veranderingen')
                    ->schema([
                        Textarea::make('description')
                            ->label('Omschrijving')
                            ->columnSpan('full')
                            ->required()
                            ->rows(10),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->toggleable()
                    ->label('#')
                    ->getStateUsing(fn ($record) => sprintf("%05d", $record?->id)),

                Tables\Columns\TextColumn::make('priority')
                    ->badge()
                    ->sortable()
                    ->toggleable()
                    ->label('Prioriteit'),

                Tables\Columns\TextColumn::make('status_id')
                    ->badge()
                    ->sortable()
                    ->toggleable()
                    ->label('Status'),

                Tables\Columns\TextColumn::make('created_by_user')
                    ->getStateUsing(fn ($record) => $record?->createByUser?->name)
                    ->toggleable()
                    ->placeholder('Algemeen')
                    ->label('Melder'),

                TileColumn::make('AssignedByUser')
                    ->sortable()
                    ->placeholder('Geen')
                    ->getStateUsing(fn($record) => $record?->AssignedByUser?->name)
                    ->label('Medewerker')
                    ->toggleable()
                    ->searchable(['first_name', 'last_name'])
                    ->image(fn($record) => $record?->AssignedByUser?->avatar),

                Tables\Columns\TextColumn::make('department.name')
                    ->sortable()
                    ->toggleable()
                    ->badge()
                    ->placeholder('Geen')
                    ->label('Afdeling'),

                Tables\Columns\TextColumn::make('description')
                    ->sortable()
                    ->limit(50)
                    ->wrap()
                    ->toggleable()
                    ->lineClamp(2)
                    ->label('Omschrijving'),

                Tables\Columns\TextColumn::make('type.name')
                    ->badge()
                    ->sortable()
                    ->toggleable()
                    ->label('Type'),
            ])
            ->recordUrl(fn($record): string => route('filament.app.resources.tickets.view', ['record' => $record]))
            ->filters(
                [
  Filter::make('hide_closed')
    ->label('Gesloten tickets verbergen')
    ->toggle() // maakt een aan/uit switch
    ->default(true) // standaard aan
    ->query(fn (Builder $query, $state): Builder =>
        $state
            ? $query->where('status_id', '!=', 7)
            : $query
    )
    ->indicateUsing(fn ($state): ?string =>
        $state ? 'Gesloten tickets verborgen' : null
    )
    
    // standaard: gesloten tickets verbergen
                ], layout: FiltersLayout::Modal)
            ->filtersFormColumns(4)
            ->actions([
                Tables\Actions\Action::make('openObject')
                    ->icon('heroicon-m-eye')
                    ->url(fn($record) => route('filament.app.resources.tickets.view', ['record' => $record]))
                    ->label('Bekijk'),
                
                Tables\Actions\EditAction::make()
                        ->label('Snel bewerken')
                        ->slideover()
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->link()
                    ->icon('heroicon-m-plus')
                    ->modalWidth(MaxWidth::FourExtraLarge)
                    ->modalHeading('Ticket toevoegen')
                    ->slideOver()
                    ->modalDescription('Geef de onderstaande gegevens op om de ticket aan te maken.')
                    ->label('Ticket toevoegen'),
            ])
            ->bulkActions([])
            ->emptyState(view("partials.empty-state"));
    }
}
