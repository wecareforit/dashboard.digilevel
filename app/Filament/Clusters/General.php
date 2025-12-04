<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class General extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static ? string $navigationGroup = 'Systeembeheer';
    protected static ? string $navigationLabel = 'Basisgegevens';

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

}
