<?php
namespace App\Filament\Resources\ProjectsResource\Pages;

use App\Filament\Resources\ProjectsResource;
use App\Models\Project;
use App\Models\ProjectStatus;
use Asmit\ResizedColumn\HasResizableColumn;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Database\Eloquent\Builder;
use Relaticle\CustomFields\Filament\Tables\Concerns\InteractsWithCustomFields;

class ListProjects extends ListRecords
{
    protected static string $resource = ProjectsResource::class;
    protected static ?string $title   = 'Projecten';
    use InteractsWithCustomFields;
    use HasResizableColumn;
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->modalWidth(MaxWidth::FourExtraLarge)
                ->modalHeading('Project toevoegen')
                ->modalDescription('Voeg een nieuwe project toe door de onderstaande gegeven zo volledig mogelijk in te vullen.')
                ->icon('heroicon-m-plus')
                ->modalIcon('heroicon-o-plus')
                ->slideOver()
                ->label('Project toevoegen'),
        ];
    }
    public function getHeading(): string
    {
        return "Project - Overzicht";
    }

    public function getTabs(): array
    {

        $projectStatuses = ProjectStatus::whereIsActive(1)->orderBy('sort', 'asc')->get();

        $tabs['Alles'] = Tab::make()
            ->modifyQueryUsing(fn(Builder $query) => Project::query())
            ->badge(Project::count());

        foreach ($projectStatuses as $projectStatus) {
            $tabs[$projectStatus->name] = Tab::make()
                ->ModifyQueryUsing(fn(Builder $query) => $query->where('status_id', $projectStatus->id))
                ->badge(Project::query()->where('status_id', $projectStatus->id)->count());
        }

        return $tabs;
    }
}
