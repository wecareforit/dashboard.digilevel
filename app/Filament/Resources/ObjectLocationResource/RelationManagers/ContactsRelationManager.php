<?php
namespace App\Filament\Resources\ObjectLocationResource\RelationManagers;

use App\Models\Contact;
use App\Models\ContactObject;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use LaraZeus\Tiles\Forms\Components\TileSelect;
use LaraZeus\Tiles\Tables\Columns\TileColumn;

class ContactsRelationManager extends RelationManager
{
    protected static bool $isScopedToTenant = false;
    protected static string $relationship   = 'contactsObject';
    protected static ?string $icon          = 'heroicon-o-user';
    protected static ?string $title         = 'Contactpersonen';

    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        // $ownerModel is of actual type Job
        return $ownerRecord->contactsObject->count();
    }

    public function form(Form $form): Form
    {
        return $form

            ->schema([

            ]);
    }

    public function table(Table $table): Table
    {
        return $table

            ->columns([

                TileColumn::make('contact.name')
                    ->description(fn($record) => $record->contact?->function)

                    ->image(fn($record) => $record->contact?->avatar),

                TextColumn::make('contact.email')
                    ->placeholder('-')
                    ->Url(function (object $record) {
                        return "mailto:" . $record?->contact?->email;
                    })
                    ->label('Emailadres'),

                TextColumn::make('contact.department')
                    ->placeholder('-')
                    ->label('Afdeling'),

                TextColumn::make('contact.function')
                    ->placeholder('-')
                    ->label('Functie'),

                TextColumn::make('contact.phone_number')
                    ->placeholder('-')
                    ->Url(function (object $record) {
                        return "tel:" . $record?->contact?->phone_number;
                    })
                    ->label('Telefoonnummers')
                    ->description(fn($record): ?string => $record?->mobile_number ?? null),
            ])
            ->emptyState(view('partials.empty-state-small'))

            ->filters([
                //
            ])
            ->headerActions([

                Action::make('createContact')
                    ->label('Toevoegen')

                    ->modalHeading('Contactpersoon toevoegen')
                    ->form([
                        Grid::make(2)
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

                            ]),

                    ])
                    ->mutateFormDataUsing(function (array $data): array {
                        //Maak de contactpersoon aan
                        $contact_id = Contact::insertGetId([
                            'first_name'   => $data['first_name'],
                            // 'company_id'   => Filament::getTenant()->id,
                            'last_name'    => $data['last_name'],
                            'department'   => $data['department'],
                            'email'        => $data['email'],
                            'function'     => $data['function'],
                            'phone_number' => $data['phone_number'],
                        ]);

                        ContactObject::create([
                            'model'      => 'location',
                            'contact_id' => $contact_id,
                            'model_id'   => $this->getOwnerRecord()->id,
                        ]);

                        return $data;
                    })

                ,

                Action::make('Attach')
                    ->modalWidth(MaxWidth::Large)
                    ->modalHeading('Contactpersoon toevoegen')
                    ->modalDescription('Koppel een bestaande contactpersoon aan deze locatie')

                    ->label('Koppel bestaand contact')
                    ->form([

                        TileSelect::make('contact_id')
                            ->searchable(['first_name', 'last_name', 'email'])
                            ->model(Contact::class)
                            ->titleKey('first_name')
                            ->imageKey('avatar')
                            ->descriptionKey('email')
                            ->label('Contactnaam')

                        ,

                    ])
                    ->action(function (array $data) {
                        ContactObject::create(
                            [
                                'model_id'   => $this->ownerRecord->id,
                                'model'      => 'location',
                                'contact_id' => $data['contact_id'],
                            ]
                        );
                    }),

                // Action::make('openContact')->label('Open Contact')
                //     ->url(function ($record) {
                //         return "/" . Filament::getTenant()->id . "/contacts/" . $record->contact_id;

                //     })->icon('heroicon-s-user'),

            ])->recordUrl(function (object $record) {
            return "/contacts/" . $record->contact_id;
        })

            ->actions([

                Action::make('openCOntact')
                    ->label('Open contact')
                    ->url(function ($record) {
                        return "/contacts/" . $record->contact_id;

                    })
                ,

                Action::make('Detach')
                    ->label('Ontkoppel')
                    ->requiresConfirmation()
                    ->action(function (array $data, $record): void {
                        $record->delete();
                    }),

            ])
            ->bulkActions([

            ]);
    }
}
