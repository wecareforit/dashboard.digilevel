<?php
namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum TicketStatus: string implements HasLabel
{
     case NEW             = '1'; // Nieuw
    case IN_PROGRESS     = '2'; // In behandeling
    case ON_HOLD         = '3'; // Wacht op klant / On Hold
    case RESOLVED        = '4'; // Opgelost
    case CLOSED          = '5'; // Gesloten
    case REJECTED        = '6'; // Afgewezen / geannuleerd

    public function getLabel(): string
    {
        return match ($this) {
            self::NEW => 'Nieuw',
            self::IN_PROGRESS => 'In behandeling',
            self::ON_HOLD => 'Wacht op klant',
            self::RESOLVED => 'Opgelost',
            self::CLOSED => 'Gesloten',
            self::REJECTED => 'Afgewezen',
        };
    }

    public static function sortOrder(): array
    {
        return [
            self::NEW,
            self::IN_PROGRESS,
            self::ON_HOLD,
            self::RESOLVED,
            self::CLOSED,
            self::REJECTED,
        ];
    }
}
