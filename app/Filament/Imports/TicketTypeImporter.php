<?php
namespace App\Filament\Imports;

use App\Models\TicketType;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class TicketTypeImporter extends Importer
{
    protected static ?string $model = TicketType::class;

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

    public function resolveRecord(): ?TicketType
    {
        // return TicketType::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new TicketType();
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
