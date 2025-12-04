<?php
namespace App\Filament\Imports;

use App\Models\ProjectStatus;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class ProjectStatusImporter extends Importer
{
    protected static ?string $model = ProjectStatus::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
                ->rules(['max:255']),
            ImportColumn::make('is_active')
                ->boolean()
                ->rules(['boolean']),
            ImportColumn::make('sort')
                ->numeric()
                ->rules(['integer']),
        ];
    }

    public function resolveRecord(): ?ProjectStatus
    {
        // return ProjectStatus::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new ProjectStatus();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your project status import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
