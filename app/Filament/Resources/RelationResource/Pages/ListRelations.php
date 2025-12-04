<?php
namespace App\Filament\Resources\RelationResource\Pages;

use App\Filament\Resources\RelationResource;
use App\Models\Relation;
use App\Models\relationType;
use Asmit\ResizedColumn\HasResizableColumn;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Database\Eloquent\Builder;
use Relaticle\CustomFields\Filament\Tables\Concerns\InteractsWithCustomFields;

class ListRelations extends ListRecords
{
    use InteractsWithCustomFields;
    use HasResizableColumn;
    protected static string $resource = RelationResource::class;
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->modalWidth(MaxWidth::FourExtraLarge)
                ->modalHeading('Relatie toevoegen')
                ->modalDescription('Voeg een nieuwe relatie toe door de onderstaande gegeven zo volledig mogelijk in te vullen.')
                ->slideOver()
                ->label('Relatie toevoegen'),
        ];
    }
    public function getHeading(): string
    {
        return "Relatie - Overzicht";
    }

    public function getTabs(): array
    {

        $relationTypes = relationType::whereIsActive(1)->orderBy('sort', 'asc')->get();

        $data_all = Relation::whereHas('type', function ($query) {
            $query->where('is_active', 1);
        });

        $tabs['Alles'] = Tab::make()
            ->modifyQueryUsing(fn(Builder $query) => $data_all)
            ->badge($data_all->count());

        foreach ($relationTypes as $relationType) {
            $tabs[$relationType->name] = Tab::make()
                ->ModifyQueryUsing(fn(Builder $query) => $query->where('type_id', $relationType->id))
                ->badge(Relation::query()->where('type_id', $relationType->id)->count());
        }

        return $tabs;
    }

}
