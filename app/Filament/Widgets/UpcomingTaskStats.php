<?php

namespace App\Filament\Widgets;

use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Columns\{ImageColumn, TextColumn};
use Filament\Tables\Actions\Action;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use App\Filament\Resources\TaskResource;
use Carbon\Carbon;

class UpcomingTaskStats extends BaseWidget
{
    protected static ?string $heading = 'Aankomende taken';
    protected static ?string $pollingInterval = '60s';
    protected int | string | array $columnSpan = '6';
    protected ?string $tableHeight = '100px';
    
    protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return Task::query()
            ->where('employee_id', Auth::id())
            ->whereDate('begin_date', '>', Carbon::today())
            ->limit(5);
    }

    protected function getTableColumns(): array
    {
        return [
            ImageColumn::make('make_by_employee.avatar')
                ->size(30)
                ->square()
                ->circular()
                ->stacked()
                ->label('')
                ->tooltip(fn($record) =>
                    $record->make_by_employee_id === $record->employee_id
                        ? 'Gemaakt door: ' . $record->make_by_employee?->name . ' (ook eigenaar)'
                        : implode(', ', array_filter([
                            'Medewerker: ' . $record->employee?->name,
                            'Gemaakt door: ' . $record->make_by_employee?->name,
                        ]))
                )
                ->getStateUsing(fn($record) =>
                    $record->make_by_employee_id === $record->employee_id
                        ? [$record->make_by_employee?->avatar]
                        : [$record->make_by_employee?->avatar, $record->employee?->avatar]
                ),

            TextColumn::make('type')
                ->badge()
                ->sortable()
                ->width('100px')
                ->label('Type'),

            TextColumn::make('priority')
                ->badge()
                ->sortable()
                ->width('150px')
                ->label('Prioriteit'),

            TextColumn::make('description')
                ->label('Taak')
                ->grow()
                ->placeholder('-')
                ->description(fn($record) => $record->begin_date
                    ? 'Start op: ' . date("d-m-Y", strtotime($record->begin_date))
                    : '-'
                ),
        ];
    }

    protected function getTableHeaderActions(): array
    {
        return [
            Action::make('go_to_all_task')
                ->label('Alle taken bekijken')
                ->link()
                ->url(TaskResource::getUrl('index'))
                ->color('primary'),
        ];
    }

    protected function getTableEmptyState(): ?\Illuminate\Contracts\View\View
    {
        return view('components.empty-state', [
            'createUrl' => TaskResource::getUrl('index') . '?open=create',
        ]);
    }

    protected function isTablePaginationEnabled(): bool
    {
        return false;
    }
}



