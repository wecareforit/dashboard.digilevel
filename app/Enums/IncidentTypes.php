<?php

namespace App\Enums;


use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;


 

enum IncidentTypes: string implements HasLabel,HasColor
{
    case TYPE01 = "1";
    case TYPE02 = "2";
    case TYPE03 = "3";
    case TYPE04 = "4";


 


    public function getlabel(): string
    {
        return match ($this) {
            self::TYPE01 => 'Slijtage',
            self::TYPE02 => 'Extern',
            self::TYPE03 => 'Vandalisme',
            self::TYPE04 => 'Technisch'
        //     self::NOT_COMPLETED => 'Niet afgrond',
        //     self::APPROVED_REPEAT => 'Goedgekeurd met herhaalpunten',
         };
    }

    public function HasLabel(): string
    {
        return match ($this) {
            self::TYPE01 => 'Slijtage',
            self::TYPE02 => 'Extern',
            self::TYPE03 => 'Vandalisme',
            self::TYPE04 => 'Technisch'
        //     self::NOT_COMPLETED => 'Niet afgrond',
        //     self::APPROVED_REPEAT => 'Goedgekeurd met herhaalpunten',
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
            self::TYPE01 => 'success',
            self::TYPE02 => 'success',
            self::TYPE03 => 'danger',
            self::TYPE04 => 'warning',
 
        };
    }
}

