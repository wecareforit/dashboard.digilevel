<?php
namespace App\Filament\Resources\ProjectsResource\RelationManagers;

use App\Models\ProjectStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

//Models

//Form

//Table

class ReactionsRelationManager extends RelationManager
{
    protected static string $relationship = "Reactions";
    protected static ?string $title       = 'Reacties';
    protected static ?string $icon        = 'heroicon-o-chat-bubble-left-right';

    public function hasCombinedRelationManagerTabsWithForm(): bool
    {
        return true;
    }

    public function getContentTabIcon(): ?string
    {
        return 'heroicon-m-eye';
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Textarea::make("reaction")
                ->rows(7)
                ->label("Opmerking")
                ->columnSpan(3)
                ->autosize()
                ->required(),

            Select::make("status_id")
                ->label("Status")
                ->reactive()
                ->options(ProjectStatus::whereIsActive(1)->orderBy('sort', 'asc')->pluck('name', 'id'))
            ,

            DateTimePicker::make("created_at")
                ->label("Invoegdatum / tijd")
                ->default(now())
                ->format("d-m-Y H:i:s"),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute("name")
            ->columns([

                Tables\Columns\TextColumn::make("status.name")
                    ->sortable()
                    ->label("Status")
                    ->placeholder('-')
                    ->badge(),
                Tables\Columns\TextColumn::make("created_at")
                    ->dateTime("d-m-Y H:i:s")
                    ->sortable()
                    ->label("Toegevoegd op"),
                Tables\Columns\TextColumn::make("user.name")
                    ->sortable()
                    ->label('Medewerker'),
                Tables\Columns\TextColumn::make("reaction")
                    ->label('Reactie')
                    ->grow(true)->wrap(),

            ])->emptyState(view('partials.empty-state-small'))
            ->filters([
                //No Filters
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->modalHeading('Project reactie toevoegen')
                    ->modalDescription('Pas de bestaande tijdregistratie aan door de onderstaande gegevens zo volledig mogelijk in te vullen.')
                    ->tooltip('Toevoegen')
                    ->label('Toevoegen')
                    ->modalIcon('heroicon-o-plus')

                    ->mutateFormDataUsing(function (array $data): array {
                        $data["user_id"] = auth()->id();
                        if (! $data["status_id"]) {
                            $data["status_id"] = $this->getOwnerRecord()->status_id;
                        }
                        return $data;
                    })->label("Reactie toevoegen")
                    ->after(function ($livewire) {
                    }),
            ])
            ->searchable(false)
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalHeading('Project reactie wijzigen')
                    ->tooltip('Bewerken')
                    ->label('Bewerken')
                    ->modalIcon('heroicon-m-pencil-square')
                ,
                Tables\Actions\DeleteAction::make()
                    ->label(""),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([]),
            ]);
    }
}
