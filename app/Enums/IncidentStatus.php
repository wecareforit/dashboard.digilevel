<?php

namespace App\Enums;


use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;


enum IncidentStatus: string implements HasLabel,HasColor
{
    case STATUS01 = "1";
    case STATUS02 = "2";
    case STATUS03 = "3";
    case STATUS04 = "4";

    
    public function label(): string
    {
        return match($this)
        {
            self::STATUS01 => 'Nieuw',
            self::STATUS02 => 'Wacht op klant',
            self::STATUS03 => 'Wacht op leverancier',
            self::STATUS04 => 'Gesloten',
        };
    }

    public function getlabel(): string
    {
        return match ($this) {
            self::STATUS01 => 'Nieuw',
            self::STATUS02 => 'Wacht op klant',
            self::STATUS03 => 'Wacht op leverancier',
            self::STATUS04 => 'Gesloten'
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::STATUS01 => 'success',
            self::STATUS02 => 'warning',
            self::STATUS03 => 'warning',
            self::STATUS04 => 'danger',
        };
    }
}

