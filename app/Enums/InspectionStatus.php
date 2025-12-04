<?php

namespace App\Enums;


use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;


 

enum InspectionStatus: string implements HasLabel,HasColor
{
    case APPROVED = "1";
    case APPROVED_ACTIONS    = "2";
    case REJECTED = "3";
    case UNDECIDED =  "4";
    case NOT_COMPLETED = "5";
    case APPROVED_REPEAT = "6";

    
    public function label(): string
{
    return match($this)
    {
        self::APPROVED => 'Goedgekeurd',
        self::APPROVED_ACTIONS => 'Goedgekeurd met acties',
        self::REJECTED => 'Afgekeurd',
        self::UNDECIDED => 'Onbeslist',
        self::NOT_COMPLETED => 'Niet afgrond',
        self::APPROVED_REPEAT => 'Goedgekeurd met herhaalpunten',
   };
}



    public function getlabel(): string
    {
        return match ($this) {
            self::APPROVED => 'Goedgekeurd',
            self::APPROVED_ACTIONS => 'Goedgekeurd met acties',
            self::REJECTED => 'Afgekeurd',
            self::UNDECIDED => 'Onbeslist',
            self::NOT_COMPLETED => 'Niet afgrond',
            self::APPROVED_REPEAT => 'Goedgekeurd met herhaalpunten',
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
            self::APPROVED => 'success',
            self::APPROVED_ACTIONS => 'success',
            self::REJECTED => 'danger',
            self::UNDECIDED => 'warning',
            self::NOT_COMPLETED => 'primary',
            self::APPROVED_REPEAT => 'warning'
        };
    }
}

