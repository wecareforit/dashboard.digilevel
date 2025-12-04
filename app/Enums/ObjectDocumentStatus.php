<?php
namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
enum ObjectDocumentStatus: string implements HasLabel, HasColor, HasIcon {
    

    case GETEKEND = '1';
    case WACHT_OP_TEKENEN = '2';
    case CONCEPT = '3';
    case CANCELLED = '4';

    public function getlabel(): string
    {
        return match($this) {
            self::GETEKEND => 'Getekend',
            self::WACHT_OP_TEKENEN => 'Wacht op tekenen medewerker',
            self::CONCEPT => 'Concept',
            self::CANCELLED => 'Geannuleerd',
            
        };
    }

    public function getcolor(): string
    {
        return match($this) {
            self::GETEKEND => 'success',
            self::WACHT_OP_TEKENEN => 'warning',
            self::CONCEPT => 'primary',
                        self::CANCELLED => 'danger',
        };
    }



    public function getIcon(): string
{
    return match($this) {
        self::GETEKEND => 'heroicon-o-check-circle',        // getekend
        self::WACHT_OP_TEKENEN => 'heroicon-o-clock',       // wacht op tekenen
        self::CONCEPT => 'heroicon-o-pencil',              // concept
        self::CANCELLED => 'heroicon-o-x-circle',          // geannuleerd
    };
}



}
