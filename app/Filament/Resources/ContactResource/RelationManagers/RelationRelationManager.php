<?php
namespace App\Filament\Resources\ContactResource\RelationManagers;

use App\Models\Contact;
use App\Models\ContactObject;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RelationRelationManager extends RelationManager
{

    protected static string $relationship = 'relationsObject';
    protected static ?string $title       = 'Relaties';

    public function form(Form $form): Form
    {
        return $form

            ->schema([

            ]);
    }

    public function table(Table $table): Table
    {
        return $table

            ->columns([

                TextColumn::make('relation.name')
                    ->placeholder('-')
                    ->label('Afdeling'),
                Tables\Columns\TextColumn::make('relation.zipcode')
                    ->placeholder('-')
                    ->label('Postcode')
                    ->state(function (ContactObject $rec) {
                        return $rec->relation?->zipcode . " " . $rec?->relation?->place;
                    }),

                TextColumn::make('relation.address')
                    ->searchable()
                    ->label('Adres')
                    ->weight('medium')
                    ->placeholder('-')
                    ->alignLeft(),

                TextColumn::make('contact.phone_number')
                    ->placeholder('-')
                    ->Url(function (object $record) {
                        return "tel:" . $record?->contact?->phone_number;
                    })
                    ->label('Telefoonnummers')
                    ->description(fn($record): ?string => $record?->mobile_number ?? null),

                TextColumn::make('relation.type_id')
                    ->label('Categorie')
                    ->badge()
                    ->placeholder('-')
                    ->searchable()
                    ->sortable(),
            ])
            ->emptyState(view('partials.empty-state-small'))
            ->recordUrl(function (object $record) {
                return "/relations/" . $record->id;
            })

            ->actions([

                Action::make('openRelation')
                    ->label('Open relatie')
                    ->url(function ($record) {
                        return "/relations/" . $record->model_id;
                    })->icon('heroicon-s-credit-card')
                    ->color('warning'),

                // Action::make('Detach')
                //     ->label('Ontkoppel')
                //     ->requiresConfirmation()
                //     ->action(function (array $data, $record): void {
                //         $record->delete();
                //     }),

            ])
            ->bulkActions([

            ]);
    }
}
