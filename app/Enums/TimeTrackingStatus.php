<?php
namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum TimeTrackingStatus: string implements HasLabel, HasColor {
    case INVOICED   = "1";
    case REGISTERED = "2";
    case CANCELLED  = "3";

    public function label(): string
    {
        return match ($this) {
            self::INVOICED   => 'Gefactureerd',
            self::REGISTERED => 'Geregistreerd',
            self::CANCELLED  => 'Afgeschreven',

        };
    }

    public function getlabel(): string
    {
        return match ($this) {
            self::INVOICED   => 'Gefactureerd',
            self::REGISTERED => 'Geregistreerd',
            self::CANCELLED  => 'Afgeschreven',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::INVOICED   => 'primary',
            self::REGISTERED => 'success',
            self::CANCELLED  => 'danger',
        };
    }
}
