<?php
namespace App\Filament\Resources\ElevatorResource\RelationManagers;

use App\Models\ObjectMaintenanceContract;
use App\Models\Relation;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
// use Filament\Infolists\Components\Grid;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MaintenanceContractsRelationManager extends RelationManager
{
    protected static string $relationship = 'maintenance_contracts';
    protected static ?string $title       = 'Onderhoudscontracten';
    protected static bool $isLazy         = false;

 
    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        // $ownerModel is of actual type Job
        return $ownerRecord
            ->maintenance_contracts
            ->count();
    }
    public function form(Form $form): Form
    {
        return $form->schema([

            Grid::make([
                'default' => 3,

            ])
                ->schema([
                    Select::make("maintenance_company_id")
                        ->label("Onderhoudsbedrijf")
                        ->required()

                        ->options(Relation::where('type_id', 1)->pluck("name", "id")),

                    DatePicker::make("startdate")
                        ->label("Startdatum")
                        ->required()
                    ,

                    DatePicker::make("enddate")
                        ->label("Einddatum")
                        ->required()

                        ->hintAction(
                            Action::make('Startdatum + 1 jaar')
                                ->icon('heroicon-m-bolt')
                                ->action(function (Set $set, Get $get, $state) {

                                    $date = new DateTime($get('startdate'));
                                    $date->add(new DateInterval("P1Y")); //"Plus 1 year"

                                    $set('enddate', $date->format("m/d/y"));

                                })
                        )
                    ,
                ]),

            FileUpload::make('contract')
                ->columnSpan(3)
                ->preserveFilenames()

                ->label('Contract')
                ->directory(function () {
                    $parent_id = $this
                        ->ownerRecord->id; // Assuming you've set up relationships with eloquent
                    return '/uploads/' . $parent_id . '/maintenance_contracts';
                })->acceptedFileTypes(['application/pdf']),

            Textarea::make('remark')
                ->rows(7)
                ->label('Opmerking')
                ->columnSpan(3)
                ->autosize(),

        ]);
    }

    public function table(Table $table):
    Table {
        return $table->recordTitleAttribute('name')
            ->columns([

                Tables\Columns\TextColumn::make("maintenance_company.name")
                    ->label("Onderhoudsbedrijf")
                    ->sortable()
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make("startdate")
                    ->label("Startdatum")
                    ->dateTime("d-m-Y")
                    ->sortable()
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make("enddate")
                    ->label("Einddatum")
                    ->dateTime("d-m-Y")
                    ->sortable()
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make("remark")
                    ->label("Opmerking")

                    ->placeholder('')
                    ->wrap(),

                Tables\Columns\TextColumn::make("Geldigheid")
                    ->label("Geldigheid")
                    ->sortable()
                    ->getStateUsing(function (ObjectMaintenanceContract $record): ?string {

                        $Date1 = strtotime(date('Y-m-d', strtotime($record?->enddate))) . ' ';
                        $Date2 = strtotime(date('Y-m-d'));

                        if ($Date1 < $Date2) {
                            return 'Verlopen';
                        } else {
                            return "Geldig";
                        }

                    })->badge(),

                // Tables\Columns\TextColumn::make("count_of_maintenance")
                //     ->label("Aantal beurten")
                //     ->placeholder('-')
                //     ->alignment('center') ,

            ])
            ->paginated(false)
            ->emptyState(view('partials.empty-state-small'))
            ->defaultSort('startdate', 'desc')
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()

                    ->modalHeading('Contract toevoegen')
                    ->label('Toevoegen')])->actions([

            Tables\Actions\Action::make('Download')
                ->label('Download contract')
                ->action(fn($record) => Storage::Storage($record->contract))
                ->icon('heroicon-o-document-arrow-down')
                ->visible(function (ObjectMaintenanceContract $record): ?string {
                    return $record?->contract;
                }),
            ActionGroup::make(
                [
                    Tables\Actions\EditAction::make()
                        ->modalHeading('Wijzigcontract'),
                    Tables\Actions\DeleteAction::make(),
                ]),

        ])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([

            ])
            ]);
    }
}
