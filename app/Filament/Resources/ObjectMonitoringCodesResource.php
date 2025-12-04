<?php
namespace App\Filament\Resources;

use App\Filament\Resources\ObjectMonitoringCodesResource\Pages;
use App\Models\ObjectMonitoringCode;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ObjectMonitoringCodesResource extends Resource
{
    protected static ?string $model = ObjectMonitoringCode::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel       = "Monitorings codes";
    protected static ?string $pluralModelLabel      = 'Monitorings codes';
    protected static ?string $navigationGroup       = 'Monitorings codes';
    protected static bool $shouldRegisterNavigation = false;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('brand')
                    ->label('Merk')
                    ->required()
                    ->maxLength(255),

                TextInput::make('error_code')
                    ->label('Errorcode')
                    ->required()
                    ->maxLength(255),

                Textarea::make('description')
                    ->rows(3)
                    ->label('Oomschrijving')
                    ->columnSpan('full')
                    ->autosize(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("brand")
                    ->label("Merk")
                    ->searchable()
                    ->placeholder('-')
                    ->badge(),

                Tables\Columns\TextColumn::make("error_code")
                    ->label("Foutcode")
                    ->searchable()
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make("description")
                    ->label("Omschrijving")
                    ->searchable()
                    ->wrap()
                    ->placeholder('-'),

            ])
            ->filters([
                SelectFilter::make('brand')
                    ->label('Merk')
                    ->options([
                        'kone'      => 'Kone',
                        'otis'      => 'Otis',
                        'schindler' => 'Schindler',
                        'tci'       => 'TCO',

                    ]),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalHeading('Monitoringcode Bewerken')
                    ->modalDescription('Pas de bestaande monitoringcode aan door de onderstaande gegevens zo volledig mogelijk in te vullen.')
                    ->tooltip('Bewerken')
                    ->label('')
                    ->modalIcon('heroicon-m-pencil-square')
                ,
                Tables\Actions\DeleteAction::make()
                    ->modalHeading('Verwijderen van deze rij')
                    ->label(''),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //     Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyState(view("partials.empty-state"));

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
            'index' => Pages\ListObjectMonitoringCodes::route('/'),
            //  'create' => Pages\CreateObjectMonitoringCodes::route('/create'),
            //  'edit'   => Pages\EditObjectMonitoringCodes::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
