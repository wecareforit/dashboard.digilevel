<?php

namespace App\Filament\Resources\ObjectResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Forms\Components\Textarea;
use App\Models\ObjectFeatures;
use App\Models\Feature;
use Filament\Tables\Actions\ActionGroup;
use Filament\Support\Enums\MaxWidth;

use Filament\Forms\Components\Select;

class FeatureRelationManager extends RelationManager
{
    protected static string $relationship = 'features';
    protected static ?string $title = "Kenmerken";

    protected static bool $isLazy = false;
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make("feature_id")
                ->label("Kenmerk")
                ->required()
                ->options(Feature::where('model','object')->pluck("description", "id")) ,
                
                Textarea::make('remark')
                    ->rows(4)
                    ->label('Extra opmerking')
                    ->columnSpan(3)
                    ->autosize()
                    ->hint(fn ($state, $component) => "Aantal karakters: ". $component->getMaxLength() - strlen($state) . '/' . $component->getMaxLength())
                    ->maxlength(255)
                    ->reactive()
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
           
            ->columns([
                Tables\Columns\TextColumn::make('feature.description')
                    ->label('Kenmerk'),
                    
                Tables\Columns\TextColumn::make('remark')
                    ->label('Omschrijving')
                    ->grow()
            ]) ->paginated(false)
            ->emptyState(view('partials.empty-state-small'))
          
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Toevoegen')
                    ->modalWidth(MaxWidth::Large)
                    ->modalHeading('Kenmerk toevoegen'),
            ])
            ->actions([

                ActionGroup::make(
                    [
                        Tables\Actions\EditAction::make()
                            ->modalWidth(MaxWidth::Large)
                            ->modalHeading('Kenmerk wijzigen')
                            ->label('Wijzigen'),
                        
                        Tables\Actions\DeleteAction::make()
                            ->label('Verwijderen'),
            ])
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
