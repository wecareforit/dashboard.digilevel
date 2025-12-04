<?php
namespace App\Filament\Resources\RelationLocationResource\RelationManagers;

use App\Models\contactType;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use LaraZeus\Tiles\Tables\Columns\TileColumn;

class ContactsRelationManager extends RelationManager
{
    protected static bool $isScopedToTenant = false;
    protected static string $relationship   = 'contactsObject';
    protected static ?string $icon          = 'heroicon-o-user';
    protected static ?string $title         = 'Contactpersonen';

    // public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    // {
    //     return in_array('Contactpersonen', $ownerRecord?->type->options) ? true : false;
    // }

    public function form(Form $form): Form
    {
        return $form

            ->schema([Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('first_name')
                            ->label('Voornaam')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('last_name')
                            ->label('Achternaam')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('email')
                            ->label('E-mailadres')
                            ->email()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('department')
                            ->label('Afdeling')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('function')
                            ->label('Functie')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('phone_number')
                            ->label('Telefoonnummer')
                            ->maxLength(255),

                        Forms\Components\Select::make('type_id')
                            ->label('Categorie')
                            ->options(contactType::where('is_active', 1)->pluck("name", "id"))
                        ,

                    ]),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table

            ->columns([

                TileColumn::make('name')
                    ->description(fn($record) => $record->function)
                    ->sortable()
                    ->image(fn($record) => $record->avatar),
                TextColumn::make("type.name")
                    ->label("Categorie")
                    ->placeholder("-")
                    ->badge()
                    ->color('primary')
                    ->toggleable(),
                TextColumn::make('email')
                    ->placeholder('-')
                    ->Url(function (object $record) {
                        return "mailto:" . $record?->email;
                    })
                    ->label('Emailadres'),

                TextColumn::make("department")
                    ->label("Afdeling")
                    ->placeholder("-")
                    ->toggleable(),

                TextColumn::make("function")
                    ->label("Functie")
                    ->placeholder("-")
                    ->toggleable(),

                TextColumn::make("phone_number")
                    ->label("Telefoonnummer")
                    ->toggleable()
                    ->placeholder("-"),

                TextColumn::make("mobile_number")
                    ->label("Intern Telefoonnummer")
                    ->toggleable()
                    ->placeholder("-"),

            ])
            ->emptyState(view('partials.empty-state-small'))

            ->filters([
                //
            ])
            ->headerActions([

                Tables\Actions\CreateAction::make('createContact')
                    ->label('Toevoegen')

                    ->Icon('heroicon-m-plus')

                    ->modalHeading('Contactpersoon toevoegen')
                    ->mutateFormDataUsing(function (array $data): array {
                         $data['type_id'] = 2;
                        $data['relation_id'] = $this->getOwnerRecord()->relation_id;
                        return $data;
                    }),

            ])->recordUrl(function (object $record) {
            return "/contacts/" . $record->contact_id;
        })

            ->actions([

                EditAction::make()
                    ->modalHeading('Contact Bewerken')
                    ->modalDescription('Pas het bestaande contact aan door de onderstaande gegevens zo volledig mogelijk in te vullen.')
                    ->tooltip('Bewerken')
                    ->label('Bewerken')
                    ->modalIcon('heroicon-m-pencil-square')
                ,
                DeleteAction::make()
                    ->modalIcon('heroicon-o-trash')
                    ->tooltip('Verwijderen')
                    ->label('')
                    ->modalHeading('Verwijderen')
                    ->color('danger'),

            ])
            ->bulkActions([

            ]);
    }
}
