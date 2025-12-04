<?php
namespace App\Filament\Resources;

use App\Enums\InspectionStatus;
use App\Filament\Resources\ElevatorInspectionResource\Pages;
use App\Filament\Resources\ElevatorInspectionResource\RelationManagers;
use App\Models\Elevator;
use App\Models\ElevatorInspection;
use App\Models\Relation;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;

 
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables\Actions;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Infolists\Components\Card;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Filament\Tables\Columns\BadgeColumn;


class ElevatorInspectionResource extends Resource
{
    protected static ?string $model            = ElevatorInspection::class;
    protected static ?string $navigationLabel  = "Keuringen";
    protected static ?string $navigationIcon   = 'heroicon-m-check-badge';
    protected static ?string $modelLabel       = 'Keuring';
    protected static ?string $pluralModelLabel = 'Keuringen';
    protected static ?string $navigationGroup  = 'Liften';
    protected static ?int $navigationSort      = 4;

    public static function shouldRegisterNavigation(): bool
    { 
         return setting('module_elevators') ?? false;
    }
public static function infolist(\Filament\Infolists\Infolist $infolist): \Filament\Infolists\Infolist
{
    return $infolist
        ->schema([
          \Filament\Infolists\Components\Card::make()
    ->schema([
        \Filament\Infolists\Components\Grid::make()
            ->schema([
                // Left column: logo
              

                // Right column: stacked text entries (just list them in order)
                \Filament\Infolists\Components\TextEntry::make('type')
                    ->label('Type keuring')
                    ->badge()
                    ->placeholder('Niet opgegeven'),

                    \Filament\Infolists\Components\TextEntry::make('nobo_number')
                        ->label('Rapport nobonummer')
                         ,


                \Filament\Infolists\Components\TextEntry::make('status_id')
                    ->label('Status')
                    ->badge()
                    ->placeholder('Niet opgegeven'),

             
                      \Filament\Infolists\Components\ViewEntry::make('status')
                    ->view('filament.infolists.entries.inspection_company_logo')
                    ->extraAttributes([
                        'style' => 'width: 15px; height: auto; display: block;',
                    ]),


            ])
            ->columns(4), // Two columns: first=logo, second=all text entries stacked
                ]),
    
    
     

            // Second card: lift and company info
            \Filament\Infolists\Components\Card::make()
                ->extraAttributes(['class' => 'm-0 p-0'])
                ->schema([
                    \Filament\Infolists\Components\TextEntry::make('elevator.location')
                        ->label('Liftadres')
                        ->getStateUsing(fn($record) => $record?->elevator?->location
                            ? "{$record->elevator->location->address} {$record->elevator->location->zipcode} {$record->elevator->location->place}"
                            : "Niet gekoppeld")
                        ->placeholder('Geen object gevonden'),

                    \Filament\Infolists\Components\TextEntry::make('elevator.maintenance_company.name')
                        ->label('Onderhoudspartij')
                        ->placeholder('Niet opgegeven'),

                    \Filament\Infolists\Components\TextEntry::make('objectStatus')
                        ->label('Installatie nummer')
                        ->badge()
                        ->getStateUsing(function ($record) {
                            $elevator = Elevator::where('nobo_no', $record->nobo_number)->first();
                            return $elevator?->nobo_no ?? 'Geen object gekoppeld';
                        })
                        ->tooltip(function ($record) {
                            $elevator = Elevator::where('nobo_no', $record->nobo_number)->first();
                            if (! $elevator) {
                                return 'Geen gekoppeld object gevonden in de database met nobo-nummer ' . $record->nobo_number . '.';
                            }
                            $location = $elevator->location_id ? "Locatie ID: {$elevator->location_id}" : 'Geen locatie';
                            return "Nobo-nummer: {$elevator->nobo_no}\nType: {$elevator->type}\n{$location}";
                        })
                        ->color(fn($state) => $state === 'Geen object gekoppeld' ? 'danger' : 'success'),



                    \Filament\Infolists\Components\TextEntry::make('elevator.location.management.name')
                        ->label('Beheerder')
                        ->placeholder('Niet opgegeven'),


                         \Filament\Infolists\Components\TextEntry::make('executed_datetime')
                        ->label('Uitvoerdatum')
                        ->dateTime('d-m-Y')
                        ->placeholder('Niet opgegeven'),

                    \Filament\Infolists\Components\TextEntry::make('end_date')
                        ->label('Einddatum')
                          ->color(function ($state) {
        if (!$state) {
            return null; // no color if empty
        }

        // Convert state to Carbon instance for comparison
        $date = \Carbon\Carbon::parse($state);
        return $date->isPast() ? 'danger' : 'primary'; // red if past, default otherwise
    })
                        ->dateTime('d-m-Y')
                        ->placeholder('Niet opgegeven'),
                        
                ])
                ->columns(4),

            // Third card: nobonummer & installation number
         

           
        ]);
}

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(4)
                ->schema([
                    DatePicker::make("executed_datetime")
                        ->label("Uitvoerdatum")
                        ->required(),


                        
                    DatePicker::make("end_date")
                        ->label("Einddatum")
                        ->required(),
                    Select::make("status_id")
                        ->searchable()
                        ->label("Status")
                        ->required()
                        ->options(InspectionStatus::class),
                    Select::make("type")
                        ->label("Type keuring")
                        ->searchable()
                        ->options([
                            "Periodieke keuring"    => "Periodieke keuring",
                            "Modernisering keuring" => "Modernisering keuring",
                            "Oplever keuring"       => "Oplever keuring",
                        ]),
                ]),
            Grid::make(4)
                ->schema([
                    Select::make("object_id")
                        ->label("NoBo Nummer")
                        ->required()
                        ->options(Elevator::whereNot('nobo_no', null)->pluck('nobo_no', 'id'))
                        ->searchable(),
                    Select::make("inspection_company_id")
                        ->label("Keuringsinstantie")
                        ->required()
                        ->options(Relation::where('type_id', 3)->pluck("name", "id")),
                ]),
            Grid::make(2)
                ->schema([
                    FileUpload::make('document')
                        ->columnSpan(1)
                        ->label('Rapportage'),
                    Textarea::make('remark')
                        ->rows(3)
                        ->label('Opmerking')
                        ->columnSpan(1)
                        ->autosize(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                

                     TextColumn::make('objectStatus')
    ->label('Nobonummer')
    ->badge()
    ->getStateUsing(function ($record) {
        // Try to find the elevator with the given nobo_number
        $elevator = Elevator::where('nobo_no', $record->nobo_number)->first();

        // Always return a string (important!)
        return $elevator?->nobo_no ?? 'Geen object gekoppeld';
    })
    ->color(function ($state) {
        // If the state equals the fallback text, show red, else green
        return $state === 'Geen object gekoppeld'
            ? 'danger'
            : 'success';
    })
    
    ->tooltip(function ($record) {
    $elevator = Elevator::where('nobo_no', $record->nobo_number)
        ->with('location') // make sure to eager-load the relation
        ->first();

    if (! $elevator) {
        return 'Geen gekoppeld object gevonden in de database met nobo-nummer ' . $record->nobo_number . '.';
    }

    $location = $elevator->location
        ? "{$elevator->location->address} {$elevator->location->zipcode} {$elevator->location->place}"
        : 'Geen locatie';

    return "Nobo-nummer: {$elevator->nobo_no}\nType: {$elevator->type}\nLocatie: {$location}";
})
->color(fn($state) => $state === 'Geen object gekoppeld' ? 'danger' : 'success')
,


                 

 
                 TextColumn::make('location_id')
                 ->label('Liftadres')
                      ->getStateUsing(fn($record) => $record?->elevator?->location
                                            ? "{$record->elevator->location->address} {$record->elevator->location->zipcode} {$record->elevator->location->place}"
                                            : "Niet gekoppeld")
                                        ->placeholder('Geen object gevonden'),




                TextColumn::make("itemdata_count")
                    ->counts("itemdata")
                    ->label("Punten")
                    ->toggleable()
                    ->sortable()
                    ->badge()
                    ->alignment(Alignment::Center)
                    ->color("success"),
                TextColumn::make("actions_count")
                    ->counts("actions")
                    ->label("Acties")
                    ->toggleable()
                    ->sortable()
                    ->badge()
                    ->alignment(Alignment::Center)

                    
                    ->color("success"),
 


                TextColumn::make("elevator.maintenance_company.name")
                    ->label("Onderhoudspartij")
                          ->placeholder('Niet opgegeven')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                TextColumn::make("inspectioncompany.name")
                    ->label("Instantie")
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                TextColumn::make("type")
                    ->label("Type keuring")
                    ->sortable(),
                TextColumn::make("status_id")
                    ->label("Status")
                    ->badge(),
                TextColumn::make("executed_datetime")
                    ->dateTime("d-m-Y")
                    ->label("Begindatum")
                    ->toggleable(),
                TextColumn::make("end_date")
                    ->dateTime("d-m-Y")
                    ->toggleable()
                    ->label("Einddatum"),
                TextColumn::make("location.customer.name")
                    ->searchable()
                    ->label("Relatie")
                    ->url(function (object $record) {
                        return "/app/customers/" . $record->customer_id . "";
                    })
                    ->icon("heroicon-c-link")
                    ->placeholder("Niet opgegeven"),
            ])
            ->filters([
                SelectFilter::make('status_id')
                    ->label("Status")
                    ->options(InspectionStatus::class),
                SelectFilter::make('inspection_company_id')
                    ->label('Keuringinstantie')
                    ->multiple()
                    ->options(Relation::where('type_id', 3)->pluck('name', 'id')),
            ], layout: FiltersLayout::AboveContent)
            ->filtersFormColumns(6)
            ->actions([
                Actions\ViewAction::make()
                    ->color('gray')
                    ->tooltip('Openkeuring')
                    ->label('')
                    ->color('info')
                    ->icon('heroicon-o-arrow-up-left'),
                    
                DeleteAction::make()
                    ->modalIcon('heroicon-o-trash')
                    ->tooltip('Verwijderen')
                    ->label('')
                    ->modalHeading('Contactpersoon verwijderen')
                    ->color('danger'),
            ])
            ->bulkActions([])
            ->emptyState(view('partials.empty-state'));
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ItemdataRelationManager::class,
        //    RelationManagers\ActionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListElevatorInspections::route('/'),
            'create' => Pages\CreateElevatorInspection::route('/create'),
         'edit'   => Pages\EditElevatorInspection::route('/{record}'),
    'view'   => Pages\ViewElevatorInspection::route('/{record}'),
        ];
    }
}
 