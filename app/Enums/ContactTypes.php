<?php
namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasColor;

enum ContactTypes: string implements HasLabel, HasIcon, HasColor {
    case EMPLOYEE = '1';
    case CONTACT  = '2';

    public function getlabel(): string
    {
        return match ($this) {
            self::EMPLOYEE => 'Medewerker',
            self::CONTACT => 'Extern',


        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::EMPLOYEE     => 'heroicon-o-user',
            self::CONTACT     => 'heroicon-s-building-library',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::EMPLOYEE     => 'gray',
            self::CONTACT     => 'warning',
        };
    }

    
}
