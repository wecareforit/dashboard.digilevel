<?php
namespace App\Filament\Resources;

use App\Filament\Resources\RelationResource\Pages;
use App\Filament\Resources\RelationResource\RelationManagers;
use App\Models\Relation;
use App\Models\relationType;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Infolists\Components;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group; // Alias toevoegen om conflict te voorkomen
use Filament\Tables\Table;
use Relaticle\CustomFields\Filament\Forms\Components\CustomFieldsComponent;
use Relaticle\CustomFields\Filament\Infolists\CustomFieldsInfolists;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Enums\FiltersLayout;
class RelationResource extends Resource
{

    protected $listeners            = ["refresh" => '$refresh'];
    protected static ?string $model = Relation::class;

    protected static ?string $navigationIcon       = 'heroicon-s-building-library';
    protected static ?string $navigationLabel      = "Relaties";
    protected static ?string $pluralModelLabel     = 'Relaties';
    protected static ?string $recordTitleAttribute = 'asdasd';

    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\Section::make()->schema([

                Forms\Components\TextInput::make("name")
                    ->label("Naam organistie")
                    ->required()

                    ->columnSpan("full"),

                Forms\Components\Select::make('type_id')
                    ->required()
                    ->label("Categorie")
                    ->options(RelationType::where('is_active', 1)->pluck('name', 'id')),

                //])
                // ->columns(3)
                // ->columnSpan(4),
            ]),

            Forms\Components\Section::make('Contactgegevens')->schema([
                Grid::make(4)->schema([
                    Forms\Components\TextInput::make("emailaddress")
                        ->label("E-mailadres")
                        ->email()
                        ->columnSpan(2),

                    Forms\Components\TextInput::make("phonenumber")
                        ->label("Telefoonnummer")
                        ->numeric() // Alleen cijfers toestaan
                        ->maxLength(10)
                        ->mutateDehydratedStateUsing(fn($state) => preg_replace('/[^0-9]/', '', $state))
                        ->columnSpan(2),

                    Forms\Components\TextInput::make("website")
                        ->label("Website")
                        ->columnSpan(2),
                ]),
            ]),

            Forms\Components\Section::make()->schema([

                Forms\Components\Textarea::make("remark")
                    ->label("Notitie")
                    ->columnSpan("full"),
            ]),

            // Add the CustomFieldsComponent
            CustomFieldsComponent::make()
                ->columnSpanFull(),

        ]);

    }

    public static function infolist(Infolist $infolist): Infolist
    {

        return $infolist->schema([
            Tabs::make('Contact Informatie') // Hoofd-tab component
                ->columnSpan('full')
                ->tabs([
                    Tabs\Tab::make('Algemene Informatie')
                        ->icon('heroicon-o-information-circle')
                        ->schema([
                            Components\TextEntry::make('name')
                                ->label("Organisatie naam")

                                ->placeholder("Niet opgegeven"),

                            Components\TextEntry::make('type.name')
                                ->label("Categorie")
                                ->badge()
                                ->placeholder("Niet opgegeven"),

                            Components\TextEntry::make("parentaddress.address")
                                ->label("Adres")
                                ->columnSpan(2)
                                ->getStateUsing(function ($record): ?string {
                                    if ($record?->parentaddress) {
                                        return $record?->parentaddress?->address . " " . $record?->parentaddress?->zipcode . " - " . $record?->parentaddress?->place;
                                    } else {
                                        return "Geen locatie toegevoegd";
                                    }
                                })
                                ->icon('heroicon-o-clipboard-document')
                                ->placeholder("Niet opgegeven")
                                ->copyable()                       // Enables copy to clipboard
                                ->copyMessage('Adres gekopieerd!') // Success message
                                ->copyMessageDuration(1500)        // Message display duration
                                ->extraAttributes([
                                    'class' => 'cursor-pointer hover:text-primary-500 hover:underline', // Adds underline on hover
                                ]),

                            Components\TextEntry::make('website')
                                ->label("Website")
                                ->placeholder("Niet opgegeven")
                                ->url(fn($record) => $record->website)
                                ->icon('heroicon-m-link'),
                            Components\TextEntry::make('emailaddress')
                                ->label("E-mailadres")
                                ->url(fn($record) => "mailto:" . $record->emailaddress)
                                ->icon('heroicon-m-envelope')
                                ->placeholder("Niet opgegeven"),

                            Components\TextEntry::make('phonenumber')
                                ->label("Telefoonnummer")
                                ->placeholder("Niet opgegeven")
                                ->url(fn($record) => "tel:" . $record->phonenumber)
                                ->icon('heroicon-m-phone')
                                // Components\TextEntry::make('country')
                                //     ->label("Land")
                                //     ->placeholder("Niet opgegeven")

                                ->columns(4)])->columns(4),

                ]),

            Section::make()
                ->visible(fn($record) => $record?->remark ?? false)

                ->schema([
                    // ...

                    Components\TextEntry::make('remark')
                        ->label("Notitie")

                        ->placeholder("Geen Notitie"),
                ]),

            // Custom Fields
            CustomFieldsInfolists::make()
                ->columnSpanFull(),

        ]);

    }

    public static function table(Table $table): Table
    {
        return    $table->columns([

            Tables\Columns\TextColumn::make('name')
                ->searchable()
                ->description(function ($record) {
                    return $record->remark;
                })
                ->weight('medium')
                ->wrap()
                ->alignLeft()
                ->placeholder('-')
                ->label('Naam organistie'),

            Tables\Columns\TextColumn::make("parentaddress.address")
                ->toggleable()
                ->label("Adres")
                ->description(function ($record) {

                }),

            Tables\Columns\TextColumn::make('parentaddress.zipcode')
                ->placeholder('-')
                ->label('Postcode'),

            Tables\Columns\TextColumn::make('parentaddress.place')
                ->placeholder('-')
                ->label('Plaats'),

            Tables\Columns\TextColumn::make('type.name')
                ->label('Categorie')
                ->columnSpan("full")
                ->badge()
                ->placeholder('-')
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('phonenumber')
                ->searchable()
                ->toggleable()
                ->placeholder('-')
                ->url(fn($record) => "tel:" . $record->phonenumber)
                ->icon('heroicon-m-phone')
                ->label('Telefoonnummer'),

            // Tables\Columns\TextColumn::make('website')
            //     ->searchable()
            //     ->toggleable()
            //     ->placeholder('-')
            //     ->url(fn($record) => "https://" . $record->website)
            //     ->icon('heroicon-m-link')
            //     ->label('Website'),

            // Tables\Columns\TextColumn::make('emailaddress')
            //     ->searchable()
            //     ->toggleable()
            //     ->url(fn($record) => "https://" . $record->emailaddress)
            //     ->icon('heroicon-m-envelope')
            //     ->placeholder('-')
            //     ->label('Emailadres'),

        ])
            ->filters([

                // SelectFilter::make('type_id')
                //     ->label('Categorie')
                //     ->options(relationType::where('is_active', 1)->pluck('name', 'id')),
               Tables\Filters\TrashedFilter::make()
                    ->label('Relaties')
                    ->trueLabel('Alleen gearchiveerde relaties')
                    ->falseLabel('Zonder gearchiveerde relaties')
                    ->placeholder('Alle relaties')

    ], layout: FiltersLayout::Modal)
            ->filtersFormColumns(2)
          
            ->actions([
                ViewAction::make()
                    ->label('Bekijk')
                    ->modalIcon('heroicon-o-eye'),
                Tables\Actions\ActionGroup::make([
                    EditAction::make()
                        ->modalHeading('Contact Bewerken')
                        ->modalDescription('Pas het bestaande contact aan door de onderstaande gegevens zo volledig mogelijk in te vullen.')
                        ->tooltip('Bewerken')
                        ->slideOver()
                        ->label('Bewerken')

                    ,
                    DeleteAction::make()                  
                        ->tooltip('Archief relatie')
                        ->label('Archiveer ')
                        ->modalIcon('heroicon-o-trash')
                        ->modalHeading('Archiveren')
                        ->modalDescription('Weet je zeker dat je deze relatie wilt archiveren?')
                        ->modalButton('Ja, archiveren')
                        ->color('danger'),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make(

                    [Tables\Actions\DeleteBulkAction::make()

                            ->modalHeading('Verwijderen van alle geselecteerde rijen'),

                        RestoreBulkAction::make(),

                    ])])
            ->emptyState(view('partials.empty-state'));
    }

    public static function getRelations(): array
    {
        return [
          RelationManagers\ObjectsRelationManager::class,
            RelationManagers\TicketRelationManager::class,
         //   RelationManagers\PeopleRelationManager::class,
           RelationManagers\EmployeesRelationManager::class,
           RelationManagers\ContactsRelationManager::class,
            RelationManagers\LocationsRelationManager::class,
            RelationManagers\TasksRelationManager::class,
            RelationManagers\NotesRelationManager::class,
            RelationManagers\AttachmentsRelationManager::class,
            RelationManagers\TimeTrackingRelationManager::class,
            RelationManagers\ProjectsRelationManager::class,
                   
            

            //RelationManagers\DepartmentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRelations::route('/'),
            // 'edit' => Pages\EditRelation::route('/{record}/edit'),
            'view'  => Pages\ViewRelation::route('/{record}'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ["name", "type.name"];
    }

    public static function getGlobalSearchResultDetails($record): array
    {

        return [
            'Naam'      => $record?->name ?? "Onbekend",
            'Categorie' => $record?->type?->name ?? "Onbekend",
        ];

    }

    public static function getModelLabel(): string
    {
        return 'Relatie';
    }
    public static function getPluralModelLabel(): string
    {
        return 'Relaties';
    }

}
