<?php
namespace App\Filament\Resources\ElevatorResource\RelationManagers;

use App\Models\Relation;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MaintenanceVisitsRelationManager extends RelationManager
{
    protected static string $relationship = 'maintenance_visits';
    protected static ?string $title       = 'Onderhoudsbeurten';
    protected static bool $isLazy         = false;

    public static function getBadge($ownerRecord, string $pageClass): ?string
    {
        return $ownerRecord->maintenance_visits->count();
    }

    // public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    // {

    //     return in_array('Onderhoudsbeurten', $ownerRecord?->type?->options) ? true : false;
    // }

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

                    DatePicker::make("execution_date")
                        ->label("Uitvoerdatum"),

                    DatePicker::make("planning_date")
                        ->label("Plandatum"),
                ]),

            FileUpload::make('document')
                ->columnSpan(3)
                ->preserveFilenames()
                ->label('Werkbon / Document / Rapport')
                ->visibility('private')->directory(function () {
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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([

                Tables\Columns\TextColumn::make("maintenance_company.name")
                    ->label("Onderhoudsbedrijf")
                    ->sortable()
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make("planning_date")
                    ->label("Plandatum")
                    ->dateTime("d-m-Y")
                    ->sortable()
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make("execution_date")
                    ->label("Uitvoerdatum")
                    ->dateTime("d-m-Y")
                    ->sortable()
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make("remark")
                    ->label("Opmerking")

                    ->placeholder('')
                    ->wrap(),

                Tables\Columns\TextColumn::make("status_id")
                    ->label("Status")
                    ->getStateUsing(function ($record): ?string {

                        if (empty($record->execution_date)) {
                            return 'Gepland';
                        } else {
                            return "Uitgevoerd";
                        }

                    })->badge()->color('primary'),

            ])
            ->paginated(false)
            ->emptyState(view('partials.empty-state-small'))
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('Toevoegen')
                    ->modalHeading('Onderhoudsbeurt toevoegen'),

                // ActionGroup::make(
                //     [
                //         Tables\Actions\EditAction::make()
                //             ->modalHeading('Wijzigcontract'),
                //         Tables\Actions\DeleteAction::make()
                //     ]),

            ])
            ->actions([
                ActionGroup::make(
                    [
                        Tables\Actions\EditAction::make()->modalHeading('Onderhoudsbeurt wijzigen'),
                        Tables\Actions\DeleteAction::make(),
                        Tables\Actions\Action::make('Download')
                            ->label('Download')
                            ->action(fn($record) => Storage::disk('private')
                                    ->download($record->document))
                            ->icon('heroicon-o-document-arrow-down')
                            ->visible(function ($record): ?string {
                                return $record?->document;
                            }),

                    ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
