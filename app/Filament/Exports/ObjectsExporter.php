<?php

namespace App\Filament\Exports;

use App\Models\ObjectsAsset;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
 
class ObjectsExporter extends Exporter
{
    protected static ?string $model = ObjectsAsset::class;

    public static function getColumns(): array
    {
        return [
              ExportColumn::make('name'),
                ExportColumn::make('type.name')
                ->label('Categorie'),
                
                ExportColumn::make('brand')
                ->label('Merk'),

                ExportColumn::make('model')
                ->label('Model'),


                ExportColumn::make('employee.name')
                ->label('Medewerker'),


                ExportColumn::make('serial_number')
                ->label('Serienummer'),

 


        ];
    }


      public static function getTitle(): string
    {
        return 'Users Export';
    }

    

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your object export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
