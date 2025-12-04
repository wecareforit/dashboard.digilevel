<?php
namespace App\Filament\Resources;

use App\Filament\Resources\ContactTypeResource\Pages;
use App\Models\contactType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Table;

class ContactTypeResource extends Resource
{
    protected static ?string $model                 = contactType::class;
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $navigationLabel       = "Contactpersoon categorieen";
    protected static ?string $title                 = "Contactpersoon categorieen";
    protected static ?string $pluralModelLabel      = 'Contactpersoon categorieen';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label('Naam')
                    ->maxLength(255)
                    ->columnSpan("full"),

                // Forms\Components\Toggle::make('is_active')
                //     ->default(true),

            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Actief')
                    ->width('100px'),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label('Naam')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->modalWidth(MaxWidth::Medium),
                Tables\Actions\DeleteAction::make()->label(''),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->emptyState(view('partials.empty-state'));

    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageContactTypes::route('/'),
        ];
    }
}
