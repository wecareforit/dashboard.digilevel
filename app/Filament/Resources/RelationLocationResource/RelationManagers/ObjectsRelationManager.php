<?php
namespace App\Filament\Resources\RelationLocationResource\RelationManagers;

use App\Enums\ElevatorStatus;
 
use App\Models\Relation;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

use App\Filament\Exports\ObjectsExporter;
use Filament\Tables\Actions\ExportAction;
use Filament\Actions\Exports\Models\Export;
use Filament\Tables\Actions\ExportBulkAction;
use App\Models\Brand;
use App\Models\Employee;
use App\Models\ObjectModel;
use App\Models\ObjectType;
use App\Models\relationLocation;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;



use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;

use LaraZeus\Tiles\Tables\Columns\TileColumn;
use Filament\Forms\Components\Checkbox;
use Filament\Tables\Columns\ViewColumn;


//Form

//Table

class ObjectsRelationManager extends RelationManager
{
    protected static string $relationship = 'Objects';
    protected static ?string $title       = 'Objecten';
    protected static ?string $icon        = 'heroicon-o-arrows-up-down';

    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        // $ownerModel is of actual type Job
        return $ownerRecord->objects->count();

    }
    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return in_array('Objecten', $ownerRecord?->type->options) ? true : false;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                Wizard::make([
                    Step::make('Object inforssmatie')
                        ->schema([

                            Select::make('type_id')
                                ->label('Categorie')
  ->options(\App\Models\ObjectType::whereJsonContains('visibility', 'Locatie')->pluck('name', 'id')->toArray())
  
   
                                ->reactive()
                                ->required(),
                                // ->afterStateUpdated(function (callable $set) {
                                // $set('brand_id', null);
                          //  }),

                            TextInput::make('brand')
                                ->label('Merk'),
                                // ->options(function (callable $get) {
                                //     $type_id = $get('type_id');

                                //     return ObjectModel::query()
                                //         ->when($type_id, fn($query) => $query->where('type_id', $type_id))
                                //         ->get()
                                //         ->groupBy('brand_id')
                                //         ->map(fn($group) => $group->first()) // Only one per brand
                                //         ->filter(fn($item) => $item->brand)  // Ensure brand exists
                                //         ->mapWithKeys(fn($item) => [
                                //             $item->brand_id => $item->brand->name,
                                //         ])
                                //         ->toArray();
                                // })
  
                             //   ->disabled(fn(callable $get) => ! $get('type_id')),
                            //     ->createOptionForm([
                            //         TextInput::make('name')
                            //             ->label('Nieuwe merknaam')
                            //             ->required()
                            //             ->columnSpan('full')
                            //             ->maxLength(50),
                            //     ])->createOptionUsing(function (array $data): int {
                            //     return Brand::create($data)->getKey();
                            // }),
 
                              TextInput::make('model')
                                ->label('Model')
                                
                                // ::make('model_id')
                                // ->label('Model')
                                // ->options(function (callable $get) {
                                //     $type_id  = $get('type_id');
                                //     $brand_id = $get('brand_id');

                                //     return ObjectModel::query()
                                //         ->when($type_id, fn($query) => $query->where('type_id', $type_id)->where('brand_id', $brand_id))
                                //         ->get()
                                //         ->mapWithKeys(function ($data) {

                                //             return [
                                //                 $data->id => collect([
                                //                     $data->name,

                                //                 ])->filter()->implode(', '),
                                //             ];
                                //         })
                                //         ->toArray();
                                // })
                                // ->reactive()
                           //     ->disabled(fn(callable $get) => ! $get('brand_id'))
                            ,

                    
                            TextInput::make('name')
                                ->label('Naam')

                        ])->columns(2),

 




                    Step::make('Lift Eigenschappen')
                        ->schema([

                            Grid::make(3)

                                ->schema([
 
                                    
     TextInput::make('stopping_places')->label('Aantal stopplaatsen')->integer(),
    TextInput::make('carrying_capacity')->label('Draaggewicht ') ->integer(),
    Select::make('energy_label')->label('Energielabel ')
    
                                ->searchable()
                                        ->options(
                                            [
                                                'A' => 'A',
                                                'B' => 'B',
                                                'C' => 'C',
                                                'D' => 'D',
                                                'E' => 'E',
                                                'F' => 'F',
                                                'G' => 'G',
                                                'H' => 'H',

                                            ]

                                        ) ,
                Select::make('drive_type')->label('Aandrijving ')
    
                                ->searchable()
                                        ->options(
                                            [
                                                'Tractie ' => 'Tractie',
                                                'Hydraulisch' => 'Hydraulisch',
                                      

                                            ]

                                        ) ,
                                                                    

                                        



Checkbox::make('fire_elevator')->inline(true)->label('Brandweerlift'),
Checkbox::make('stretcher_elevator')->inline(true)->label('Brancardlift '),




                                ])
                                   ])  ->visible(function ($record) {
                                    return setting('environment_elevator');
                                })  ->visible(fn (callable $get) => 

        $get('type_id') &&
        \App\Models\ObjectType::where('id', $get('type_id'))
            ->whereJsonContains('options', 'Liften')
            ->exists()
    ),
 

                    Step::make('Toewijzing')
                        ->schema([

                            Grid::make(2)

                                ->schema([

                                    TextInput::make('serial_number')
                                        ->label('Serienummer'),

                                                    
                            TextInput::make('nobo_no')
                                ->label('Nobonummer')
                                ->visible(function ($record) {
                                    return setting('environment_elevator');
                                }),


                                

                                    // Select::make('employee_id')
                                    //     ->searchable(['first_name', 'last_name', 'email'])
                                    //     ->options(
                                    //         Employee::where('relation_id', $this->ownerRecord->relation_id)
                                          
                                    //             ->get()
                                    //             ->mapWithKeys(fn($employee) => [
                                    //                 $employee->id => "{$employee->first_name} {$employee->last_name}",
                                    //             ])
                                    //     )
                                    //     ->label('Gebruiker')
                                    //     ->visible(function ($record, callable $get) {
                                    //         $object_data = ObjectType::where('id', $get('type_id'))->first();
                                    //         if ($object_data?->visibility) {
                                    //             return in_array('Medewerker', $object_data?->visibility) ? true : false;;
                                    //         } else {
                                    //             return false;
                                    //         }
                                    //     }),

                                    Select::make('department_id')
                                        ->label('Afdeling')
                                        ->options(fn() => $this->ownerRecord?->departments?->pluck('name', 'id') ?? [])
                                        ->searchable()
                                        ->visible(function ($record, callable $get) {
                                            $object_data = ObjectType::where('id', $get('type_id'))->first();
                                            if ($object_data?->visibility) {
                                                return in_array('Afdeling', $object_data?->visibility) ? true : false;;
                                            } else {
                                                return false;
                                            }
                                        })
                                        ->placeholder('Selecteer een afdeling'),

                                    Select::make('location_id')
                                        ->searchable(['name', 'address', 'place'])
                                        ->options(
                                            RelationLocation::where('relation_id', $this->ownerRecord->relation_id)
                                                ->get()
                                                ->mapWithKeys(fn($ObjectLocation) => [
                                                    $ObjectLocation->id => "{$ObjectLocation->name} {$ObjectLocation->address}",
                                                ])
                                        )
                                        ->label('Locatie'),
                                ]),
                            TextInput::make('uuid')
                                ->label('Uniek id nummer')
                                ->hint('Scan een barcode sticker'),
                        ]),

                    Step::make('Opmerking')
                        ->schema([
                            Textarea::make("remark")
                                ->rows(7)
                                ->label('Opmerking')
                                ->columnSpan('full')
                                ->autosize()
                                ->hint(fn($state, $component) => "Aantal karakters: " . $component->getMaxLength() - strlen($state) . '/' . $component->getMaxLength())
                                ->maxlength(255)
                                ->reactive(),
                        ]),
                ])->columnSpanFull(),
                //  ->submitAction(new \Filament\Forms\Components\Actions\ButtonAction('Submit')),

            ]);
    }

     public function table(Table $table): Table
    {
        return $table
  ->groups([

          Group::make('type.name')
                ->label('Categorie name'),

                            Group::make('type.name')
                               ->titlePrefixedWithLabel(false)
                ->label('Merk'),

                            Group::make('brand')
                               ->titlePrefixedWithLabel(false)
                ->label('Merk'),

                
                            Group::make('model')
                               ->titlePrefixedWithLabel(false)
                ->label('Model'),

                
                            Group::make('"employee.name')
                               ->titlePrefixedWithLabel(false)
                ->label('Gebruiker')

        ])      ->defaultGroup('type.name')


            ->columns([

                TextColumn::make("type.name")
                    ->badge()
                    ->label("Categorie")
                    ->placeholder("-")
                    ->toggleable()
                    ->sortable()
                    ->searchable(),

                    
ViewColumn::make('fire_elevator')->view('filament.tables.columns.elevators.properties') 
->label("Eigenschappen")
           
                    ->placeholder("-")
                    ->toggleable()
                    ->sortable()
                    ->searchable()     ->visible(function ($record) {
                            return setting('environment_elevator');
                    }),
     


                TextColumn::make("brand")
                    ->label("Merk")
                    ->placeholder("-")
                    ->toggleable()
                    ->sortable()
                    ->searchable(),

                TextColumn::make("model")
                    ->label("Model")
                    ->placeholder("-")
                    ->toggleable()
                    ->sortable()
                    ->searchable(),
                TileColumn::make('name')
                    ->description(fn($record) => $record->function)
                    ->placeholder("-")
                    ->sortable()

                    ->image(fn($record) => $record->avatar),

                // TextColumn::make("employee.name")
                //     ->badge()
                //     ->label("Gebruiker")
                //     ->placeholder("-")
                //     ->toggleable()
                //     ->sortable()
                //     ->searchable(),

                TextColumn::make("serial_number")
                    ->label("Serienummer")
                    ->placeholder("-")
                    ->toggleable()
                    ->sortable()
                    ->searchable(),

      
                TextColumn::make("drive_type")
                    ->label("Aandrijving")
                    ->visible(function ($record) {
                            return setting('environment_elevator');
                    })
                    ->badge()
                    ->placeholder("-")
                    ->toggleable()
                    ->sortable()
                    ->searchable(),

               
                TextColumn::make("stopping_places")
                    ->label("Stopplaasen")
                    ->visible(function ($record) {
                            return setting('environment_elevator');
                    })
                    ->badge()
                    ->placeholder("-")
                    ->toggleable()
                    ->sortable()
                    ->searchable(),     
    
        

ViewColumn::make('energy_label')->view('filament.tables.columns.energylabel')      ->label("Energylabel")
           
                    ->placeholder("-")
                    ->toggleable()
                    ->sortable()
                    ->searchable()     ->visible(function ($record) {
                            return setting('environment_elevator');
                    }),
     
 


            ])
            ->emptyState(view('partials.empty-state-small'))
            ->recordUrl(function ($record) {
                return "/objects/" . $record->id;
            })
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                SelectFilter::make('type_id')
                    ->label('Categorie')
                    ->options(ObjectType::where('is_active', 1)->pluck('name', 'id')),

            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->link()
                    ->modalHeading('Object aanmaken')
                 //   ->modalDescription('Koppel vaste objecten aan een locatie of een medewerker. Wil je objecten koppelen aan aan een medewerker of locatie? Maak dan eerst een medewerker of locatie aan.')
                    ->label('Toevoegen')
                    ->slideOver()
                    ->icon('heroicon-m-plus')
                            ->mutateFormDataUsing(function (array $data): array {

                        $data['customer_id'] = $this->ownerRecord?->relation_id;
                      $data['location_id'] = $this->ownerRecord?->is;

        return $data;
    }),
            ])
            ->actions([

                Tables\Actions\RestoreAction::make(),

                Tables\Actions\EditAction::make()
                    ->modalHeading('Object Bewerken')
                    ->modalDescription('Pas de bestaande object aan door de onderstaande gegevens zo volledig mogelijk in te vullen.')
                    ->tooltip('Bewerken'),

                Tables\Actions\ActionGroup::make([

                    Tables\Actions\DeleteAction::make()
                        ->modalIcon('heroicon-o-trash')
                        ->tooltip('Verwijderen')
                        ->modalHeading('Verwijderen')
                        ->color('danger'),

                ]),
            ])
            ->bulkActions([
                ExportBulkAction::make()
                ->label('Exporteren')
                ->fileName(fn (Export $export): string => "objecten-{$export->getKey()}")
                ->exporter(ObjectsExporter::class)
                ->modalHeading('Exporteerd gegevens') 
            ]);
    }
}
