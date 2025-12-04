<?php
namespace App\Filament\Resources;

use App\Filament\Imports\ObjectTypeImporter;
use App\Filament\Resources\ObjectTypeResource\Pages;
use App\Models\ObjectType;
use Filament\Forms;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

use Filament\Forms\Components\CheckboxList;
use Illuminate\Support\HtmlString;

use Nben\FilamentRecordNav\Concerns\WithRecordNavigation;

class ObjectTypeResource extends Resource {

    use WithRecordNavigation;
    protected static ?string $model                 = ObjectType::class;
    protected static ?string $navigationIcon        = 'heroicon-o-rectangle-stack';
    protected static bool $shouldRegisterNavigation = false;
    public static function form( Form $form ): Form {
        return $form

        ->schema( [

            Forms\Components\TextInput::make( 'name' )
            ->required()
            ->columnSpan( 'full' )
            ->maxLength( 255 ),

            ToggleButtons::make( 'visibility' )
            ->label( 'Koppelbaar aan' )
            ->multiple()
            ->options( [
                'Medewerker' => 'Medewerker',
                'Locatie'    => 'Locatie',
                'Werkplek'   => 'Werkplek',
                'Afdeling'   => 'Afdeling',
            ] )
            ->required()
            ->inline(),
          

            CheckboxList::make( 'options' )
            ->label( 'Modules ' )
            ->options( [
                'Keuringen'             => 'Keuringen',
                'Onderhoudscontracten'  => 'Onderhoudscontracten',
                'Tickets'               => 'Tickets',
                'Onderhoudsbeurten'     => 'Onderhoudsbeurten',
                'Liften'                => 'Liften',
                'Roltrappen'            => 'Roltrappen',
                'Garantie'              => 'Garantie',
                'E-Mail instellingen'   => 'E-Mail instellingen',
                'Netwerken'             => 'Netwerken LAN',
                'Aankoopgegevens'       => 'Aankoop gegevens',
                'Afbeeldingen'          => 'Afbeeldingen',
                'Voertuigen'            => 'Voertuigbeheer',
            ])
            ->descriptions([
                'Keuringen'             => 'Beheer en plan keuringen van installaties',
                'Onderhoudscontracten'  => 'Overzicht en beheer van onderhoudscontracten',
                'Tickets'               => 'Klachten en serviceverzoeken beheren',
                'Onderhoudsbeurten'     => 'Periodieke onderhoudsbeurten beheren en plannen',
                'Liften'                => 'Module specifiek voor liftenbeheer',
                'Roltrappen'            => 'Module specifiek voor roltrappenbeheer',
                'Garantie'              => 'Beheer garantievoorwaarden en vervaldata',
                'E-Mail instellingen'   => 'Instellingen voor e-mailverkeer en notificaties',
                'Netwerken'             => 'Netwerkgegevens beheren zoals LAN, WIFI & IP-adressen',
                'Aankoopgegevens'       => 'Beheer van inkoopgegevens, facturen en leveranciers',
                'Afbeeldingen'          => 'Afbeeldingen Bibliotheek',
                'Voertuigen'            => 'Registratie en onderhoud van voertuigen.',
            ])
            ->bulkToggleable()
            ->columns(1)
            ->required()
            ->columnSpan( 'full' )
            ->searchable()
            ->noSearchResultsMessage( 'Geen eigenschappen gevonden' )
            ->searchPrompt( 'Zoek naar eigenschap' )
            ,

        ] );

    }

    public static function table( Table $table ): Table {
        return $table
        ->headerActions( [
            ImportAction::make()
            ->importer( ObjectTypeImporter::class )
            ->label( 'Importeren' ),
        ] )
        ->columns( [

            Tables\Columns\ToggleColumn::make( 'is_active' )
            ->label( 'Actief' )

            ->width( '100px' ),

            Tables\Columns\TextColumn::make( 'name' )
            ->searchable()

            ->sortable(),

            Tables\Columns\TextColumn::make( 'options' )
            ->label( 'Opties' )
            ->badge(),

            Tables\Columns\TextColumn::make( 'visibility' )
            ->label( 'Zichtbaarheid' )
            ->placeholder( '-' )

            ->badge(),

        ] )
        ->filters( [
            Tables\Filters\Filter::make( 'is_active' )
            ->query( fn( Builder $query ): Builder => $query->where( 'is_active', true ) )
            ->label( 'Only active' ),
        ] )
        ->actions( [
            Tables\Actions\EditAction::make()
            ->modalHeading( 'Object Type Bewerken' )
            ->modalDescription( 'Pas het bestaande object type aan door de onderstaande gegevens zo volledig mogelijk in te vullen.' )
            ->tooltip( 'Bewerken' )
            ->slideover()
            ->label( 'Bewerken' )

            ,
            Tables\Actions\DeleteAction::make()
            ->modalIcon( 'heroicon-o-trash' )
            ->tooltip( 'Verwijderen' )
            ->label( '' )
            ->modalHeading( 'Verwijderen' )
            ->color( 'danger' ),
        ] )
        ->bulkActions( [
            Tables\Actions\BulkActionGroup::make( [
                Tables\Actions\DeleteBulkAction::make(),
            ] ),
        ] )->emptyState( view( 'partials.empty-state' ) );

    }

    public static function getPages(): array {
        return [
            'index' => Pages\ListObjectTypes::route( '/' ),
            //    'view'  => Pages\ViewObjectType::route( '/{record}' ),
            //  'edit'  => Pages\EditObjectType::route( '/{record}' ),
        ];
    }
}
