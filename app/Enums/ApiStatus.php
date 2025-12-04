<?php

namespace App\Enums;


use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;


 

enum ApiStatus: string implements HasLabel,HasColor
{
    case SUCCESS = "1";
    case ERROR    = "2";
    
    

    public function getlabel(): string
    {
        return match ($this) {
            self::SUCCESS => 'Succesvol',
            self::ERROR => 'Foutmelding',
 
        };
    }

    // public function getIcon(): ?string
    // {
    //     return match ($this) {
    //         self::EXTERN => 'heroicon-o-cpu-chip',
    //         self::INTERN => 'heroicon-m-check'
    //     };
    // }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::SUCCESS => 'success',
            self::ERROR => 'warning'
        };
    }
}

