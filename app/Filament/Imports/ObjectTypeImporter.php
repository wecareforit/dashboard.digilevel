<?php
namespace App\Filament\Imports;

use App\Models\ObjectType;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class ObjectTypeImporter extends Importer
{
    protected static ?string $model = ObjectType::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
                ->rules(['max:255']),
            ImportColumn::make('is_active')
                ->boolean()
                ->rules(['boolean']),
            ImportColumn::make('options'),
            ImportColumn::make('visibility'),
        ];
    }

    public function resolveRecord(): ?ObjectType
    {
        // return ObjectType::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new ObjectType();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your object type import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
