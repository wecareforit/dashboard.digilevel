<?php
namespace App\Filament\Resources\RelationResource\RelationManagers;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class NotesRelationManager extends RelationManager
{
    protected static string $relationship = 'Notes';
    protected static ?string $title       = 'Notities';
    protected static ?string $icon        = 'heroicon-o-clipboard-document';

    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        // $ownerModel is of actual type Job
        return $ownerRecord->notes->count();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                Textarea::make('note')
                    ->rows(7)
                    ->label('Notitie')
                    ->columnSpan(3)
                    ->required()
                    ->autosize()
                    ->hint(fn($state, $component) => "Aantal karakters: " . $component->getMaxLength() - strlen($state) . '/' . $component->getMaxLength())
                    ->maxlength(255)
                    ->reactive(),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([

                Tables\Columns\TextColumn::make("created_at")
                    ->dateTime("d-m-Y H:i:s")
                    ->sortable()
                    ->width('120px')
                    ->label("Toegevoegd op"),

                Tables\Columns\TextColumn::make('note')->label('Notitie')->wrap(),
                // ->description(function ($record) {

                //     return "Toegevoegd door: " . $record->user->name . " " . date("d-m-Y", strtotime($record?->created_at)) . " om " . date("H:i", strtotime($record?->updated_at));

                // }
                // ),

            ])->emptyState(view('partials.empty-state'))

            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->mutateFormDataUsing(function (array $data): array {
                    $data['user_id']    = auth()->id();
                    $data['updated_at'] = null;
                    $data['model']      = "relation";
                    $data['item_id']    = $this->getOwnerRecord()->id;
                    return $data;
                })->label('Notitie toevoegen')
                    ->modalHeading('Notitie toevoegen')
                    ->link()
                    ->icon('heroicon-m-plus')
                    ->modalIcon('heroicon-o-plus'),

            ])
            ->actions([

                Tables\Actions\ActionGroup::make([

                    Tables\Actions\EditAction::make()
                        ->label('Wijzigen')

                        ->modalHeading('Notitie wijzigen'),

                    Tables\Actions\DeleteAction::make()

                        ->modalHeading('Bevestig actie')
                        ->modalDescription('Weet je zeker dat je deze notities wilt verwijderen?'),

                ]),

            ])
            ->bulkActions([
                //
            ]);
    }
}
