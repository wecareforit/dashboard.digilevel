<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Models\Contact;
use Filament\Forms;
use Filament\Forms\Components\Grid;
 
use Filament\Forms\Form;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use LaraZeus\Tiles\Tables\Columns\TileColumn;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use Relaticle\CustomFields\Filament\Forms\Components\CustomFieldsComponent;
use Relaticle\CustomFields\Filament\Infolists\CustomFieldsInfolists;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon        = 'heroicon-o-user-group';
    protected static ?string $navigationLabel       = 'Contactpersonen';
    protected static ?string $title                 = 'Contactpersonen';
    protected static ?string $recordTitleAttribute  = 'name';
    protected static ?string $pluralModelLabel      = 'Contactpersonen';
    protected static bool $shouldRegisterNavigation = true;

    public static function getGloballySearchableAttributes(): array
    {
        return ['first_name', 'last_name', 'email', 'relation.name'];
    }

    public static function getGlobalSearchResultDetails($record): array
    {
        return [
            'E-mailadres' => $record?->email ?? 'Onbekend',
            'Relatie'     => empty($record?->relation?->name) ? 'Geen' : $record->relation->name,
        ];
    }
public static function form(Form $form): Form
{
    return $form->schema([
        Forms\Components\Section::make('')
            ->schema([
                // Row with image, first name, last name
                Grid::make(3)
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('Afbeelding')
                            ->image()
                            ->nullable()
                            ->imageEditor()
                            ->directory('contacts')
                            ->disk('local'),

                        Forms\Components\TextInput::make('first_name')
                            ->label('Voornaam')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('last_name')
                            ->label('Achternaam')
                            ->required()
                            ->maxLength(255),
                    ]),

                // Rest of the fields stacked vertically
                Forms\Components\TextInput::make('email')
                    ->label('E-mailadres')
                    ->maxLength(255),

                Forms\Components\TextInput::make('phone_number')
                    ->label('Telefoonnummer')
                    ->maxLength(15),

                Forms\Components\TextInput::make('function')
                    ->label('Functie')
                    ->maxLength(255),

                Forms\Components\TextInput::make('department')
                    ->label('Afdeling'),

                Forms\Components\TextInput::make('company')
                                      ->hidden(fn ($record) => $record->type === 'EMPLOYEE')
                    ->label('Bedrijf'),
            ]),

        CustomFieldsComponent::make()->columns(1),
    ]);
}



    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Tabs::make('Contact Details')
                ->columnSpan('full')
                ->tabs([
                    Tabs\Tab::make('Algemene Informatie')
                        ->icon('heroicon-o-information-circle')
                        ->schema([
                            TextEntry::make('name')->label('Naam')->placeholder('-'),
                            TextEntry::make('department.name')->label('Afdeling')->placeholder('-'),
                            TextEntry::make('function')->label('Functie')->placeholder('-'),
                            TextEntry::make('email')->label('E-mail')->placeholder('-'),
                            TextEntry::make('phone_number')->label('Telefoon')->placeholder('-'),
                            TextEntry::make('mobile_number')->label('Intern Tel')->placeholder('-'),
                            TextEntry::make('relation.name')
                                ->label('Relatie')
                                ->placeholder('-')
                                ->url(fn($record) => "/relations/" . $record->relation_id)
                                ->icon('heroicon-o-link'),
                        ])->columns(4),
                ]),

            CustomFieldsInfolists::make()->columnSpanFull(),
        ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('show_in_contactlist', true);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->description('Contactpersonen van relaties')
            ->deferLoading()
            ->groups([
                Group::make('relation_id')
                    ->getTitleFromRecordUsing(fn($record): string => ucfirst($record?->name))
                    ->label('Relatie'),
            ])
            ->columns([
                TileColumn::make('name')
                    ->description(fn($record) => $record->email)
                    ->sortable()
                    ->searchable(['first_name', 'last_name'])
                    ->image(fn($record) => $record->avatar),

                TextColumn::make('function')
                    ->placeholder('-')
                    ->sortable()
                    ->searchable()
                    ->url(fn(object $record) => $record?->function)
                    ->label('Functie'),

                TextColumn::make('type')
                    ->sortable()
                    ->searchable()
                    ->label('Type')
                    ->badge()
                    ->placeholder('-'),

                TextColumn::make('relation.name')
                    ->label('Relatie')
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('company')
                    ->label('Bedrijf')
                    ->placeholder('-')

                    ->toggleable(),

                    
                TextColumn::make('department')
                    ->label('Afdeling')
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('phone_number')
                    ->label('Telefoonnummer')
                    ->placeholder('-')
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('relation_id')
                    ->label('Relatie')
                    ->searchable()
                    ->options(fn() => \App\Models\Relation::all()
                        ->groupBy('type.name')
                        ->mapWithKeys(fn($group, $category) => [
                            $category => $group->pluck('name', 'id')->toArray(),
                        ])->toArray()),
            ])
            ->actions([
                ViewAction::make()
                    ->label('Bekijk')
                    ->modalIcon('heroicon-o-eye'),

                EditAction::make()
                    ->modalHeading('Contact Bewerken')
                    ->modalDescription('Pas het bestaande contact aan door de onderstaande gegevens zo volledig mogelijk in te vullen.')
                    ->tooltip('Bewerken')
                    ->label('Bewerken')
                    ->modalIcon('heroicon-m-pencil-square'),

                Tables\Actions\ActionGroup::make([
                    DeleteAction::make()
                        ->modalIcon('heroicon-o-trash')
                        ->tooltip('Verwijderen')
                        ->modalHeading('Verwijderen')
                        ->color('danger'),
                ]),
            ])
            ->bulkActions([
                ExportBulkAction::make()->exports([
                    ExcelExport::make()
                        ->fromTable()
                        ->withColumns([
                            Column::make('name')->heading('Naam'),
                            Column::make('email')->heading('E-Mailadres'),
                            Column::make('relation.name')->heading('Relatie'),
                            Column::make('department')->heading('Afdeling'),
                            Column::make('function')->heading('Functie'),
                            Column::make('phone_number')->heading('Telefoonnummer'),
                            Column::make('Mobiele telefoon')->heading('mobile_number'),
                        ])
                        ->withWriterType(\Maatwebsite\Excel\Excel::XLSX)
                        ->withFilename(date('m-d-Y H:i') . ' - Contactpersonen export'),
                ]),
            ])
            ->emptyState(view('partials.empty-state'));
    }

    public static function getPages(): array
    {
        return [
            'view'  => Pages\ViewContact::route('/{record}'),
            'index' => Pages\ListContacts::route('/'),
        ];
    }
}
