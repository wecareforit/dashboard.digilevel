<?php
namespace App\Filament\Resources\BrandResource\RelationManagers;

use App\Models\ObjectType;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ModelsRelationManager extends RelationManager
{
    protected static string $relationship = 'models';

    public function form(Form $form): Form
    {

        return $form

            ->schema([
                TextInput::make('name')
                    ->label('Naam of produkt nummer')
                    ->required()
                    ->maxLength(255)
                    ->required()
                    ->columnSpan(4),
                Select::make('type_id')
                    ->options(ObjectType::pluck('name', 'id'))
                    ->preload()
                    ->searchable()
                    ->label('Categorie')
                    ->createOptionForm([

                        TextInput::make('name')
                            ->label('Nieuwe categorie naam')
                            ->required()
                            ->columnSpan('full')
                            ->maxLength(50),

                        ToggleButtons::make('options')
                            ->label('Opties')
                            ->multiple()
                            ->options([
                                'Keuringen'            => 'Keuringen',
                                'Onderhoudscontracten' => 'Onderhoudscontracten',
                                'Tickets'              => 'Tickets',
                                'Onderhoudsbeurten'    => 'Onderhoudsbeurten',

                            ])
                            ->required()
                            ->inline()
                        ,

                    ])->createOptionUsing(function (array $data): int {

                    return ObjectType::create($data)->getKey();
                })
                    ->required()
                    ->columnSpan(4),

                Textarea::make("remark")
                    ->rows(7)
                    ->label('Opmerking')
                    ->columnSpan('full')
                    ->autosize()
                    ->hint(fn($state, $component) => "Aantal karakters: " . $component->getMaxLength() - strlen($state) . '/' . $component->getMaxLength())
                    ->maxlength(255)
                    ->reactive(),

            ])->columns(12);
    }

    public function table(Table $table): Table
    {
        return $table
            ->defaultPaginationPageOption(100)
            ->paginated([25, 50, 100, 'all'])
            ->recordTitleAttribute('name')

            ->columns([
                // TextColumn::make('index')
                //     ->label('#')
                //     ->rowIndex(),
                TextColumn::make('name')
                    ->label(__('asset_models.fields.name'))
                    ->searchable()
                    ->sortable()
                    ->description(function ($record) {
                        return $record->remark;
                    }),

                TextColumn::make('category.name')
                    ->badge()
                    ->label('Categorie')
                    ->searchable()
                    ->sortable(),
            ])
            ->headerActions([
                CreateAction::make(),
            ])

            ->filters([
                SelectFilter::make('type_id')
                    ->label('Categorie')
                    ->searchable()

                    ->options(ObjectType::pluck('name', 'id')),

            ])

            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyState(view('partials.empty-state'));

    }

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('asset_models.plural');
    }

    protected static function getModelLabel(): ?string
    {
        return __('asset_models.singular');
    }
}
