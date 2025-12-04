<?php

namespace App\Filament\Widgets;

use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Table;
use Filament\Tables\Columns\{ImageColumn, TextColumn};
use Filament\Tables\Actions\Action;
use App\Filament\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TodayTaskStats extends BaseWidget
{
    protected static ?string $heading = 'Mijn taken vandaag';
    protected static ?string $pollingInterval = '60s';
    protected int | string | array $columnSpan = '6';
    protected ?string $tableHeight = '400px'; // fixed table height

    
    protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return Task::query()
            ->where('employee_id', Auth::id())
            ->whereDate('begin_date', '=', Carbon::today())
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
                ->placeholder('-'),
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

    protected function getTableActions(): array
    {
        return [
            Action::make('complete')
                ->label('Voltooien')
                ->icon('heroicon-o-check')
                ->tooltip('Voltooien')
                ->color('danger')
                ->modalHeading('Actie voltooien')
                ->modalDescription('Weet je zeker dat je deze actie wilt voltooien?')
                ->modalIcon('heroicon-o-check')
                ->requiresConfirmation()
                ->visible(fn($record) => auth()->user()->can('compleet_any_task') || $record->employee_id === auth()->id())
                ->action(fn($record) => $record->update(['deleted_at' => Carbon::now()])),
        ];
    }

    protected function isTablePaginationEnabled(): bool
    {
        return false;
    }
}
