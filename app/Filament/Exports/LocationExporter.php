<?php

namespace App\Filament\Exports;

use App\Models\Location;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class LocationExporter extends Exporter
{
    protected static ?string $model = Location::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('company_id'),
            ExportColumn::make('name'),
            ExportColumn::make('street'),
            ExportColumn::make('house_number'),
            ExportColumn::make('house_number_addition'),
            ExportColumn::make('postal_code'),
            ExportColumn::make('city'),
            ExportColumn::make('country'),
            ExportColumn::make('phone_number'),
            ExportColumn::make('deleted_at'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your location export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
