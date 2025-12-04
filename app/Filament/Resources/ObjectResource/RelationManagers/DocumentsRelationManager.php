<?php

namespace App\Filament\Resources\ObjectResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\Employee;
use App\Models\ObjectsDocument;
use Saade\FilamentAutograph\Forms\Components\SignaturePad;
use App\Enums\ObjectDocumentStatus;
use Illuminate\Support\Facades\Auth;

class DocumentsRelationManager extends RelationManager
{
    protected static string $relationship = 'documents';
    protected static ?string $title = "Toewijzing / Documenten";

    public static function getBadge($ownerRecord, string $pageClass): ?string
    {
        return $ownerRecord->documents->count();
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make("employee_id")
                ->options(function (callable $get) {
                    $usedEmployeeIds = ObjectsDocument::where('status_id', '!=', ObjectDocumentStatus::CANCELLED)
                        ->pluck('employee_id')
                        ->filter()
                        ->toArray();

                    return Employee::whereNotIn('id', $usedEmployeeIds)
                        ->get()
                        ->mapWithKeys(fn($employee) => [
                            $employee->id => collect([$employee->first_name, $employee->last_name])
                                ->filter()
                                ->implode(' '),
                        ])
                        ->toArray();
                })
                ->searchable()
                ->columnSpan('full')
                ->reactive()
                ->label('Medewerker'),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make("status_id")
                    ->label("Status")
                    ->wrap()
                    ->badge()
                    ->tooltip(fn($record) => $record->cancelled_reason ? "Reden: {$record->cancelled_reason}" : null)
                    ->sortable(),

                Tables\Columns\TextColumn::make("created_at")
                    ->label("Aangemaakt op")
                    ->date('d-m-Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make("signed_at")
                    ->label("Getekend")
                    ->date('d-m-Y H:i')
                    ->placeholder('-')
                    ->sortable(),

                Tables\Columns\TextColumn::make("employee.name")
                    ->label("Medewerker")
                    ->description(fn($record) => $record->cancelled_remark ?: null)
                    ->sortable(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Nieuwe toewijzing')
                    ->modalHeading('Koppel aan gebruiker')
                    ->modalWidth('md')
                    ->createAnother(false)
                    ->modalDescription('Kies hieronder een medewerker om deze te koppelen aan dit object')
                    ->mutateFormDataUsing(fn(array $data) => [
                        'created_by_user_id' => Auth::id(),
                        'status_id' => 2,
                        ...$data,
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('cancel')
                    ->label('Annuleren / terugnemen')
                    ->color('danger')
                    ->icon('heroicon-o-x-circle')
                    ->requiresConfirmation()
                    ->modalHeading('Weet je het zeker?')
                    ->modalDescription('Bij het annuleren van deze bruikleenovereenkomst staat deze hardware niet meer op de medewerker geregistreerd')
                    ->modalSubmitActionLabel('Akkoord')
                    ->form([
                        SignaturePad::make('cancelled_signature')->label('Handtekening')->required(),
                        Forms\Components\Textarea::make('cancelled_remark')->label('Opmerking'),
                        Forms\Components\Select::make('cancelled_reason')
                            ->label('Reden van annulering')
                            ->columnSpan('full')
                            ->options([
                                'Medewerker uitdienst' => 'Medewerker uitdienst',
                                'Defect' => 'Defect',
                                'Vervangen voor andere hardware' => 'Vervangen voor andere hardware',
                                'Niet meer nodig' => 'Niet meer nodig',
                                'Gestolen' => 'Gestolen',
                                'Andere functie' => 'Andere functie',
                            ])
                            ->required(),
                    ])
                    ->action(fn($record, array $data) => $record->update([
                        'status_id' => 4,
                        'cancelled_signature' => $data['cancelled_signature'],
                        'cancelled_remark' => $data['cancelled_remark'],
                        'cancelled_by_user_id' => Auth::id(),
                        'cancelled_at' => now(),
                        'cancelled_reason' => $data['cancelled_reason'],
                    ]))
                    ->visible(fn($record) =>
                        $record->status_id != ObjectDocumentStatus::CONCEPT &&
                        $record->status_id != ObjectDocumentStatus::CANCELLED
                    ),

                Tables\Actions\Action::make('sign')
                    ->label('Tekenen')
                    ->color('success')
                    ->icon('heroicon-o-pencil')
                    ->requiresConfirmation()
                    ->modalHeading('Akkoord')
                    ->modalDescription('Bij ontvangst van deze hardware bevestig je dat je de apparaten en accessoires in goede staat hebt ontvangen. Controleer de items direct op beschadigingen of ontbrekende onderdelen. Door te ondertekenen, ga je akkoord dat deze hardware in jouw beheer komt en dat je verantwoordelijk bent voor correct gebruik en teruglevering volgens de bruikleenovereenkomst.')
                    ->modalSubmitActionLabel('Akkoord')
                    ->form([
                        SignaturePad::make('signed_signature')->label('Handtekening')->columnSpan('full')->required(),
                    ])
                    ->action(fn($record, array $data) => $record->update([
                        'status_id' => 1,
                        'signed_signature' => $data['signed_signature'],
                        'signed_at' => now(),
                    ]))
                    ->visible(fn($record) =>
                        $record->status_id != ObjectDocumentStatus::CONCEPT &&
                        $record->status_id != ObjectDocumentStatus::CANCELLED &&
                        $record->status_id != ObjectDocumentStatus::GETEKEND
                    ),

                Tables\Actions\DeleteAction::make()
                    ->modalHeading('Verwijder concept')
                    ->modalDescription('Weet je zeker dat je deze concept wilt verwijderen?')
                    ->visible(fn($record) => $record->status_id === ObjectDocumentStatus::CONCEPT),
            ])
            ->emptyState(view("partials.empty-state"));
    }
}
