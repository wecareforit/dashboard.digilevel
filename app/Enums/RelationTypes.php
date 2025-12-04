<?php
namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum RelationTypes: string implements HasLabel {
    case MAINTENANCE = '1';
    case MANAGEMENT  = '2';
    case INSPECTION  = '3';
    case SUPPLIER    = '4';
    case CUSTOMERS   = '5';
    case ADVISOR     = '6';
    public function getlabel(): string
    {
        return match ($this) {
            self::MAINTENANCE => 'Onderhoudsbedrijf',
            self::MANAGEMENT => 'Beheerder',
            self::INSPECTION => 'Keuringsinstantie',
            self::SUPPLIER => 'Leverancier',
            self::CUSTOMERS => 'Klant',
            self::ADVISOR => 'Adviseur'

        };
    }

    // public function getIcon(): ?string
    // {
    //     return match ($this) {
    //         self::EXTERN     => 'heroicon-o-cpu-chip',
    //         self::INTERN     => 'heroicon-m-check',
    //     };
    // }

    // public function getColor(): string | array | null
    // {
    //     return match ($this) {
    //         self::EXTERN     => 'gray',
    //         self::INTERN     => 'warning',
    //     };
    // }
}
