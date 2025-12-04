<?php
namespace App\Filament\Imports;

use App\Models\ticketStatus;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class TicketStatusImporter extends Importer
{
    protected static ?string $model = ticketStatus::class;
    protected $connection           = 'df';
    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
                ->rules(['max:255']),
            ImportColumn::make('sort')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('is_active')
                ->boolean()
                ->rules(['boolean']),
        ];
    }

    public function resolveRecord(): ?ticketStatus
    {
        // return TicketStatus::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new ticketStatus();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Er zijn  ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' records geïmporteerd .';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
