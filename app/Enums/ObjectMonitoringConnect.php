<?php
namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ObjectMonitoringConnect: string implements HasLabel, HasColor {
    case DISCONNECTED = "0";
    case CONNECT      = "1";
    case ERROR        = "2";

    public function getlabel(): string
    {
        return match ($this) {
            self::DISCONNECTED => 'Verbroken',
            self::CONNECT      => 'Verbinding',
            self::ERROR        => 'Foutmelding',
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
            self::DISCONNECTED => 'danger',
            self::CONNECT      => 'success',
            self::ERROR        => 'warning',

        };
    }
}
