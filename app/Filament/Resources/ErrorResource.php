<?php
namespace App\Filament\Resources;

use App\Filament\Resources\ErrorResource\Pages;
use App\Models\Error;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class ErrorResource extends Resource
{
    protected static ?string $model                 = Error::class;
    protected static ?string $navigationLabel       = "Foutmeldingen";
    protected static ?string $title                 = "Foutmeldingen";
    protected static ?string $pluralModelLabel      = 'Foutmeldingen';
    protected static ?string $navigationIcon        = 'heroicon-o-exclamation-circle';
    protected static bool $shouldRegisterNavigation = false;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->label('Code')
                    ->required()
                    ->extraAlpineAttributes(['@input' => '$el.value = $el.value.toUpperCase()'])->minLength(4)
                    ->maxLength(10),
                TextArea::make('error')
                    ->label('Oplossing')

                    ->required()
                    ->columnSpan("full")
                    ->maxLength(255),
                Forms\Components\Toggle::make('is_active')
                    ->label('Actief')
                    ->default(true),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ToggleColumn::make('is_active')->label('Zichbaar')
                    ->onColor('success')
                    ->offColor('danger')
                    ->width(100),
                TextColumn::make('code')
                    ->label('Code')
                    ->width(20)
                    ->searchable(),
                TextColumn::make('error')
                    ->label('Oplossing')
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([

                Tables\Actions\EditAction::make()
                    ->modalHeading('Foutmelding Bewerken')
                    ->modalDescription('Pas de foutmelding leverancier aan door de onderstaande gegevens zo volledig mogelijk in te vullen.')
                    ->tooltip('Bewerken')
                    ->label('')
                    ->modalIcon('heroicon-m-pencil-square')
                ,
                Tables\Actions\DeleteAction::make()
                    ->modalIcon('heroicon-o-trash')
                    ->tooltip('Verwijderen')
                    ->label('')
                    ->modalHeading('Verwijderen')
                    ->color('danger'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyState(view('partials.empty-state'));
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
            'index' => Pages\ListErrors::route('/'),
            //   'create' => Pages\CreateError::route('/create'),
            //   'edit'   => Pages\EditError::route('/{record}/edit'),
        ];
    }
}
