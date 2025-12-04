<?php
namespace App\Filament\Resources;

use App\Filament\Resources\MailSettingResource\Pages;
use App\Models\MailSetting;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MailSettingResource extends Resource
{
    protected static ?string $model                 = MailSetting::class;
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $navigationIcon        = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('mail_mailer')->default('smtp')->required()->disabled(),
            TextInput::make('mail_host')->required(),

            Select::make('mail_port')
                ->label('Mail Port')
                ->options([
                    '25'  => '25 - Standaard SMTP (onversleuteld)',
                    '465' => '465 - SMTP via SSL (SMTPS)',
                    '587' => '587 - SMTP met STARTTLS',
                ])
                ->required(),

            TextInput::make('mail_username')->required(),

            TextInput::make('mail_password')->password()->required(),

            Select::make('mail_encryption')
                ->label('Versleuteling')
                ->options([
                    'tls' => 'TLS (aanbevolen)',
                    'ssl' => 'SSL (oudere methode)',
                    ''    => 'Geen versleuteling',
                ])
                ->default('tls')
                ->required(),

            TextInput::make('mail_from_address')->email()->required(),
            TextInput::make('mail_from_name')->required(),
        ]);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListMailSettings::route('/'),
            'create' => Pages\CreateMailSetting::route('/create'),
            'edit'   => Pages\EditMailSetting::route('/{record}/edit'),
        ];
    }
}
