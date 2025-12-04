<?php
namespace App\Filament\Resources\ProjectsResource\RelationManagers;

use App\Enums\TimeTrackingStatus;
use App\Models\workorderActivities;
use Filament\Forms;
use Filament\Forms\Components\TextArea;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class TimeTrackingRelationManager extends RelationManager
{
    protected static string $relationship = 'timeTracking';
    protected static ?string $label       = 'Tijdregistratie';
    protected static ?string $title       = 'Tijdregistratie';
    protected static ?string $icon        = 'heroicon-o-clock';

    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        return $ownerRecord->timeTracking()->count();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('started_at')
                    ->label('Datum')
                    ->closeOnDateSelection()
                    ->default(now())
                    ->required(),
                Forms\Components\TimePicker::make('time')
                    ->label('Tijd')
                    ->seconds(false)
                    ->required(),
                Forms\Components\Select::make('status_id')
                    ->label('Status')
                    ->options(TimeTrackingStatus::class) // Using the Enum directly
                    ->default(2)
                    ->required(),
                Forms\Components\Select::make('work_type_id')
                    ->label('Type')
                    ->searchable()
                    ->options(workorderActivities::where('is_active', 1)->pluck("name", "id")->toArray())
                    ->required(),
                TextArea::make('description')
                    ->label('Omschrijving')
                    ->required()
                    ->columnSpan('full'),
                Forms\Components\Toggle::make('invoiceable')
                    ->label('Facturabel')
                    ->default(true),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('description')
            ->columns([
                TextColumn::make('started_at')
                    ->label('Datum')
                    ->sortable()
                    ->toggleable()
                    ->width(50)
                    ->alignment(Alignment::Center)
                    ->date('d-m-Y')
                    ->placeholder('-')
                    ->searchable(),
                TextColumn::make('time')
                    ->label('Tijd')
                    ->sortable()
                    ->date('H:i')
                    ->toggleable()
                    ->placeholder('-')
                    ->width(10),
                TextColumn::make('weekno')
                    ->label('Week nr.')
                    ->width(50)
                    ->placeholder('-')
                    ->toggleable()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('description')
                    ->label('Activiteit')
                    ->wrap()
                    ->placeholder('-')
                    ->searchable(),

                TextColumn::make('status_id')
                    ->sortable()
                    ->label('Status')
                    ->badge()
                    ->toggleable()
                    ->sortable()
                    ->placeholder('-')
                    ->searchable(),
                ToggleColumn::make('invoiceable')
                    ->label('Facturabel')
                    ->onColor('success')
                    ->sortable()
                    ->toggleable()
                    ->offColor('danger')
                    ->width(100),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->icon('heroicon-m-plus')
                    ->modalIcon('heroicon-o-plus')
                ,
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalHeading('Tijdregistratie Bewerken')
                    ->modalDescription('Pas de bestaande tijdregistratie aan door de onderstaande gegevens zo volledig mogelijk in te vullen.')
                    ->tooltip('Bewerken')
                    ->label('Bewerken')
                    ->modalIcon('heroicon-m-pencil-square')
                ,
                Tables\Actions\DeleteAction::make()
                    ->modalIcon('heroicon-o-trash')
                    ->tooltip('Verwijderen')
                    ->label('')
                    ->modalHeading('Verwijderen')
                    ->color('danger'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->emptyState(view("partials.empty-state"));
    }
}
