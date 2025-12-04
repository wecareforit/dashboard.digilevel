<?php

namespace App\Enums;


use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;



enum QuoteTypes: string implements HasLabel,HasColor,HasIcon
{
    case EXTERN = '1';
    case INTERN = '2';

    public function getlabel(): string
    {
        return match ($this) {
            self::EXTERN => 'Extern',
            self::INTERN => 'Intern',

        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::EXTERN => 'heroicon-o-cpu-chip',
            self::INTERN => 'heroicon-m-check',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::EXTERN => 'gray',
            self::INTERN => 'warning',
        };
    }
}

