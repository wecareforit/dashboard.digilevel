<?php
namespace App\Filament\Resources;

use App\Filament\Resources\VehicleGPSResource\Pages;
use App\Models\gpsObject;
use App\Models\Vehicle;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
//Form
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
//tables
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VehicleGPSResource extends Resource
{

    protected static ?string $model = gpsObject::class;

    protected static ?string $navigationIcon   = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel  = 'GPS Modules';
    protected static ?string $navigationGroup  = 'Algemeen';
    protected static ?string $title            = "Magazijnen";
    protected static ?string $pluralModelLabel = 'GPS modules';

    protected static ?string $recordTitleAttribute  = 'name';
    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Naam')
                    ->maxLength(255)
                    ->columnSpan('full')
                    ->required(),

                Select::make('vehicle_id')
                    ->label('Voortuig')
                    ->options(Vehicle::pluck('kenteken', 'id'))
                    ->columnSpan('full')
                    ->searchable(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('imei')
                    ->label('imei')
                    ->searchable(),

                TextColumn::make('name')
                    ->label('Naam')
                    ->searchable(),

                TextColumn::make('object_expire_dt')

                    ->label('Verloopdatum')
                    ->placeholder('Niet bekend')
                    ->date('m-d-Y')
                    ->color(
                        fn($record) => strtotime($record?->object_expire_dt) <
                        time()
                        ? "danger"
                        : "success"
                    ),

                TextColumn::make('vehicle')
                    ->getStateUsing(function ($record): ?string {
                        if ($record->vehicle?->kenteken) {
                            return strtoupper($record?->vehicle->kenteken) . " - " . $record?->vehicle->merk;

                        } else {
                            return false;
                        }
                    })

                    ->label('Voortuig')
                    ->placeholder('Niet gekoppeld')
                    ->searchable(),

            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->tooltip('Bewerken')
                    ->label('Bewerken')
                    ->modalIcon('heroicon-m-pencil-square')

                    ->modalWidth(MaxWidth::Small),
                DeleteAction::make()
                    ->modalIcon('heroicon-o-trash')
                    ->tooltip('Verwijderen')
                    ->label('')
                    ->modalHeading('Verwijderen')
                    ->color('danger'),

                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListVehicleGPS::route('/'),
            //  'create' => Pages\CreateVehicleGPS::route('/create'),
            //  'edit' => Pages\EditVehicleGPS::route('/{record}/edit'),
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
