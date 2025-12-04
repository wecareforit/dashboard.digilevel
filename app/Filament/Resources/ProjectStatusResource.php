<?php
namespace App\Filament\Resources;

use App\Filament\Imports\ProjectStatusImporter;
use App\Filament\Resources\ProjectStatusResource\Pages;
use App\Models\ProjectStatus;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Table;

class ProjectStatusResource extends Resource
{
    protected static ?string $model = ProjectStatus::class;

    protected static ?string $navigationIcon        = 'heroicon-o-rectangle-stack';
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $navigationLabel       = "Project statussen";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\TextInput::make('name')
                    ->required()
                    ->columnSpanFull()
                    ->maxLength(255),

                // Section::make('Modules')
                //     ->description('Een selectie van de modules voor deze relatie type')
                //     ->schema([

                //         ToggleButtons::make('options')
                //             ->label('Opties')
                //             ->multiple()
                //             ->options([
                //                 'Medewerkers'     => 'Medewerkers',
                //                 'Contactpersonen' => 'Contactpersonen',
                //                 'Tickets'         => 'Tickets',
                //                 'Bijlages'        => 'Bijlages',
                //                 'Tijdregistratie' => 'Tijdregistratie',
                //                 'Projecten'       => 'Projecten',
                //                 'Locaties'        => 'Locaties',
                //                 'Objecten'        => 'Objecten',
                //             ])
                //             ->required()
                //             ->inline()
                //             ->columns(2),

                //     ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                ImportAction::make()
                    ->importer(ProjectStatusImporter::class)
                    ->label('Importeren'),
            ])
            ->reorderable('sort')
            ->reorderRecordsTriggerAction(
                fn(Action $action, bool $isReordering) => $action
                    ->button()
                    ->label($isReordering ? 'Afsluiten' : 'Volgorde wijzigen'),
            )
            ->defaultSort('sort', 'asc')
            ->columns([

                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Actief')
                    ->width('100px'),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                // Tables\Columns\TextColumn::make('options')
                //     ->label('Opties')
                //     ->badge(),

            ])
            ->filters([
                //
            ])
            ->actions([

                Tables\Actions\EditAction::make()
                    ->modalHeading('Project status bewerken')

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
            ])->emptyState(view('partials.empty-state'));

    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjectStatus::route('/'),

        ];
    }
}
