<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;


enum TaskTypes: string implements HasLabel, HasColor, HasIcon
{
    case CALL_NOTE = 'call_note';
    case TODO = 'todo';
    case EMAIL = 'email';
    case MEETING = 'meeting';
    case FOLLOW_UP = 'follow_up';
    case REMINDER = 'reminder';

    public function getLabel(): string
    {
        return match ($this) {
            self::CALL_NOTE => 'Bel notite',
            self::TODO => 'Taak',
            self::EMAIL => 'E-mail versturen',
            self::MEETING => 'Vergadering',
            self::FOLLOW_UP => 'Opvolging',
            self::REMINDER => 'Herinnering',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::CALL_NOTE => 'primary',
            self::TODO => 'gray',
            self::EMAIL => 'info',
            self::MEETING => 'success',
            self::FOLLOW_UP => 'warning',
            self::REMINDER => 'danger',
        };
    }

public function getIcon(): string
{
    return match ($this) {
        self::CALL_NOTE => 'heroicon-o-phone',
        self::TODO => 'heroicon-o-check-circle',
        self::EMAIL => 'heroicon-o-envelope',
        self::MEETING => 'heroicon-o-users',
        self::FOLLOW_UP => 'heroicon-o-arrow-path',
        self::REMINDER => 'heroicon-o-bell',
    };
}
  
}