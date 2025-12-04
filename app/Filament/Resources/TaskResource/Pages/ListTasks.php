<?php
namespace App\Filament\Resources\TaskResource\Pages;

use App\Filament\Resources\TaskResource;
use App\Models\Task;
use App\Enums\Priority;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Database\Eloquent\Builder;
use Relaticle\CustomFields\Filament\Tables\Concerns\InteractsWithCustomFields;
use Illuminate\Support\Facades\Auth;
use Asmit\ResizedColumn\HasResizableColumn;

class ListTasks extends ListRecords
{
    use InteractsWithCustomFields;
    protected static string $resource = TaskResource::class;
    protected static ?string $title   = 'Alle acties';
    use HasResizableColumn;
    
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->modalWidth(MaxWidth::FourExtraLarge)
                ->modalHeading('Taak toevoegen')
                ->modalDescription('Voeg een nieuwe taak toe door de onderstaande gegeven zo volledig mogelijk in te vullen.')
                ->slideOver()
                ->label('Taak toevoegen'),
        ];
    }
    public function getHeading(): string
    {
        return "Mijn taken - Overzicht";
    }

protected function getHeaderWidgets(): array
{
    return [
      \App\Filament\Resources\TaskResource\Widgets\TaskStats::class,
       //\App\Filament\Resources\TaskResource\Widgets\TasksByPriorityChart::class,
      //  \App\Filament\Resources\TaskResource\Widgets\TasksByPriorityPie::class,
    ];
}

 

    public function getTabs(): array
    {
        return [

             'Alle' => Tab::make()
            ->modifyQueryUsing(fn (Builder $query) => 
                $query->where(function ($q) {
                    $q->where('make_by_employee_id', auth()->id())
                      ->orWhere('employee_id', auth()->id());
                })
            ),
               
            'Toegewezen aan mij'      => Tab::make()
                ->ModifyQueryUsing(fn(Builder $query) => $query->where('employee_id', auth()->id()))
                ->badgeColor('danger')
                ->badge(Task::query()->where('employee_id', auth()->id())->count()),

            'Aangemaakt door mij' => Tab::make()
                ->ModifyQueryUsing(fn(Builder $query) => Task::query()->where('make_by_employee_id', auth()->id()))
                ->badgeColor('warning')
                ->badge(Task::query()->where('make_by_employee_id', auth()->id())->count()),
          ];
    }

}

 