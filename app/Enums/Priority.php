<?php
namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum Priority: string implements HasLabel, HasColor
{
    case HIGH   = 'high';
    case MEDIUM = 'medium';
    case LOW    = 'low';

    public function getLabel(): string
    {
        return match ($this) {
            self::HIGH   => 'Hoog',
            self::MEDIUM => 'Gemiddeld',
            self::LOW    => 'Laag',
        };
    }

    // Optional: uncomment if you want icons
    // public function getIcon(): ?string
    // {
    //     return match ($this) {
    //         self::HIGH => 'heroicon-o-exclamation-triangle',
    //         self::MEDIUM => 'heroicon-o-exclamation',
    //         self::LOW => 'heroicon-o-check',
    //     };
    // }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::HIGH   => 'danger',
            self::MEDIUM => 'warning',
            self::LOW    => 'success',
        };
    }

    
}