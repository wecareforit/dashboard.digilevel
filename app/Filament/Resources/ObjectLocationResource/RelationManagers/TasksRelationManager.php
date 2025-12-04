<?php
namespace App\Filament\Resources\ObjectLocationResource\RelationManagers;

use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TasksRelationManager extends RelationManager
{
    protected static string $relationship = 'tasks';
    protected static ?string $icon        = 'heroicon-o-rectangle-stack';
    protected static ?string $title       = 'Taken';

    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        // $ownerModel is of actual type Job
        return $ownerRecord->tasks->count();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                TextInput::make('title')
                    ->label('Title')
                    ->required()
                    ->columnSpan('full'),

                Textarea::make('description')
                    ->rows(3)
                    ->label('Uitgebreide omschrijving')
                    ->helperText(str('Beschrijf de actie of taak ')->inlineMarkdown()->toHtmlString())
                    ->columnSpan('full')
                    ->autosize(),

                // Select::make('model_id')
                //     ->options(Project::pluck('name', 'id'))
                //     ->searchable()
                //     ->visible(function (Get $get, Set $set) {
                //         return $get('model') == 'project' ?? false;
                //     })
                //     ->label('Project'),

                //         TileSelect::make('contact_id')
                //             ->searchable(['first_name', 'last_name', 'email'])
                //             ->model(Contact::class)
                //             ->titleKey('name')
                //             ->imageKey('avatar')
                //             ->descriptionKey('email')
                //             ->label('Contactpersoon')

                // Select::make('model_id')
                //     ->options(ObjectsAsset::pluck('nobo_no', 'id'))
                //     ->searchable()
                //     ->visible(function (Get $get, Set $set) {
                //         return $get('model') == 'object' ?? false;
                //     })
                //     ->label('Object'),

                Select::make('employee_id')
                    ->options(User::pluck('name', 'id'))
                    ->searchable()
                    ->default(Auth::id())
                    ->label('Medewerker'),

                // Select::make('priority')
                //     ->options([
                //         '1' => 'Hoog',
                //         '2' => 'Gemiddeld',
                //         '3' => 'Laag',

                //     ])
                //     ->searchable()
                //     ->label('Prioriteit'),

                DatePicker::make('begin_date')

                    ->label('Begindatum'),

                TimePicker::make('begin_time')
                    ->label('Tijd')
                    ->seconds(false),

                DatePicker::make('deadline')
                    ->label('Einddatum'),

                // ToggleButtons::make('private')
                //     ->label('Prive actie')
                //     ->default(1)
                //     ->boolean()
                //     ->grouped(),

                Select::make('type_id')
                    ->options([
                        '1' => 'Terugbelnotitie',
                        '3' => 'Te doen',

                    ])
                    ->searchable()
                    ->default(3)
                    ->label('Type'),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->emptyState(view('partials.empty-state'))
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Titel')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Beschrijving')
                    ->limit(50),
                Tables\Columns\TextColumn::make('priority')
                    ->label('Prioriteit'),
                Tables\Columns\TextColumn::make('deadline')
                    ->label('Deadline')
                    ->date(),
                Tables\Columns\TextColumn::make('end_time')
                    ->label('Eindtijd')
                    ->time(),
                Tables\Columns\TextColumn::make('begin_time')
                    ->label('Starttijd')
                    ->time(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->modalWidth(MaxWidth::FourExtraLarge)
                    ->modalHeading('Taak toevoegen')
                    ->modalDescription('Voeg een nieuwe taak toe door de onderstaande gegeven zo volledig mogelijk in te vullen.')
                    ->icon('heroicon-m-plus')
                    ->modalIcon('heroicon-o-plus')
                    ->label('Taak toevoegen')

                    ->mutateFormDataUsing(function (array $data): array {
                        $data['model_id'] = $this->ownerRecord->id;
                        $data['model']    = 'location';
                        $data['model_id'] = $this->getOwnerRecord()->id;

                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()

                    ->label('Bewerken'),
                Tables\Actions\DeleteAction::make()

                    ->label('Verwijderen'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Geselecteerde verwijderen'),
                ]),
            ]);
    }
}
