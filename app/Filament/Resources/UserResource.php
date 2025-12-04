<?php
namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Mail\UserWelcomeMail;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Mail;
use STS\FilamentImpersonate\Tables\Actions\Impersonate;
use Tapp\FilamentAuthenticationLog\RelationManagers\AuthenticationLogsRelationManager;

class UserResource extends Resource
{
    protected static ?string $model           = User::class;
    protected static ?string $navigationIcon  = 'heroicon-o-users';
    protected static ?string $navigationLabel = "Gebruikers";
    protected static ?string $navigationGroup = 'Mijn bedrijf';

    protected static bool $shouldRegisterNavigation = true;

 


    public static function form(Form $form): Form
    {

        return $form->schema([
            TextInput::make('name')
                ->label('Naam')
                ->maxLength(255),

            TextInput::make('email')
                ->label('E-mail')
                ->email(),

            // Password::make('password')
            //     ->copyable()
            //     ->copyMessage('Wachtwoord gekopieerd')
            //     ->copyable(color: 'success')
            //     ->regeneratePassword()
            //     ->maxLength(10)
            //     ->password()
            //     ->label('Wachtwoord'),

            Select::make('roles')
                ->relationship('roles', 'name')
                ->saveRelationshipsUsing(function ($record, $state) {
                    $record->roles()->syncWithPivotValues($state, [config('permission.column_names.team_foreign_key') => getPermissionsTeamId()]);
                })
                ->label('Gebruikersrollen')
                ->columnSpan('full')
                ->multiple()
                ->preload()
                ->searchable(),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('id')
                ->label('#')
                ->sortable(),

            TextColumn::make('name')
                ->label('Naam')
                ->searchable()
                ->sortable(),

            TextColumn::make('email')
                ->label('E-mail')
                ->searchable()
                ->sortable(),

            TextColumn::make('created_at')
                ->label('Aangemaakt op')
                ->dateTime('d-m-Y H:i')
                ->sortable(),
        ])
            ->filters([
                // Filter::make('recent')
                //     ->label('Nieuwste eerst')
                //     ->query(fn(Builder $query) => $query->latest()),
            ])
            ->actions([
                EditAction::make()
                    ->modalHeading('Gebruiker Bewerken')
                    ->modalDescription('Pas de bestaande gebruiker aan door de onderstaande gegevens zo volledig mogelijk in te vullen.')
                    ->tooltip('Bewerken')
                    ->label('')
                    ->modalIcon('heroicon-m-pencil-square')
                ,
                Impersonate::make()->label('Login'),
                DeleteAction::make()
                    ->modalIcon('heroicon-o-trash')
                    ->tooltip('Verwijderen')
                    ->label('')
                    ->modalHeading('Verwijderen')
                    ->color('danger'),

                Action::make('sendMail')
                    ->label('Send Mail')
                    ->action(function ($record) {
                        $user              = $record;
                        $token             = app('auth.password.broker')->createToken($user);
                        $notification      = new \Filament\Notifications\Auth\ResetPassword($token);
                        $notification->url = \Filament\Facades\Filament::getResetPasswordUrl($token, $user);
                        // $user->notify($notification);
                        $record['token'] = $token;
                        $record['url'] = $notification->url;
                        $record['base_url'] = env('APP_URL');
                        $record['company_logo'] = setting('company_logo');
                        Mail::to($record->email)->send(new UserWelcomeMail($record));
                    })
                    ->requiresConfirmation()
                    ->modalIcon('heroicon-o-envelope')
                    ->modalHeading('Welkoms e-mail versturen?')
                    ->modalDescription('Door de welkoms e-mail te versturen, ontvangt de gebruiker een link om zijn wachtwoord opnieuw in te stellen.')
                    ->modalSubmitActionLabel('Versturen')
                    ->color('success')
                    ->label('Verstuur welkoms e-mail'),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            // 'create' => CreateUser::route('/create'),
            'edit'  => EditUser::route('/{record}/edit'),
        ];
    }
    public static function getRelations(): array
    {
        return [
            AuthenticationLogsRelationManager::class,
            // ...
        ];
    }
    public static function getModelLabel(): string
    {
        return "Gebruikers";
    }

}
