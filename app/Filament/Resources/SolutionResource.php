<?php
namespace App\Filament\Resources;

use App\Filament\Resources\SolutionResource\Pages;
use App\Models\Solution;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class SolutionResource extends Resource
{
    protected static ?string $model                 = Solution::class;
    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort      = 7;
    protected static ?string $navigationLabel  = "Oplossingen";
    protected static ?string $title            = "Oplossingen";
    protected static ?string $pluralModelLabel = 'Oplossingen';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->label('Code')
                    ->required()
                    ->extraAlpineAttributes(['@input' => '$el.value = $el.value.toUpperCase()'])->minLength(4)
                    ->maxLength(10),

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
                    ->placeholder('')
                    ->label('Code')
                    ->width(20)
                    ->searchable(),
                TextColumn::make('error')
                    ->label('Oplossing')
                    ->placeholder('')
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalHeading('Oplossing Bewerken')
                    ->modalDescription('Pas de bestaande oplossing aan door de onderstaande gegevens zo volledig mogelijk in te vullen.')
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
            'index' => Pages\ListSolutions::route('/'),
            //    'create' => Pages\CreateSolutions::route('/create'),
            //   'edit'   => Pages\EditSolutions::route('/{record}/edit'),
        ];
    }
}
