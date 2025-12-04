<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ActionStatus: string implements HasLabel, HasColor {
    case OPEN = "1";
    case CLOSED = "2";

    public function getlabel(): string
    {
        return match ($this) {
            self::OPEN => 'Open',
            self::CLOSED => 'Gesloten',

        };
    }

    // public function getIcon(): ?string
    // {
    //     return match ($this) {
    //         self::EXTERN => 'heroicon-o-cpu-chip',
    //         self::CLOSED => 'heroicon-m-check',
    //     };
    // }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::OPEN => 'gray',
            self::CLOSED => 'warning',
        };
    }
}
