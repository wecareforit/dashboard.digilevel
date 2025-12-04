<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class ElevatorsSettings extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
    protected static ? string $navigationGroup = 'Stamgegevens';
    protected static ? string $navigationLabel = 'Objecten';
    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

}
