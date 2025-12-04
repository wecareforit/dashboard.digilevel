<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;

enum TicketTypes: string implements HasLabel, HasColor, HasIcon
{
    case INCIDENT         = 'incident';         // Een storing of onderbreking
    case SERVICEVERZOEK   = 'serviceverzoek';   // Verzoek om informatie of toegang
    case PROBLEEM         = 'probleem';         // Onderliggende oorzaak van incident(en)
    case WIJZIGING        = 'wijziging';        // Aanpassing of toevoeging aan een dienst
    case RELEASE          = 'release';          // Uitrol van een wijziging
    case EVENT            = 'event';            // Melding dat er iets is gebeurd
    case TOEGANG          = 'toegang';          // Rechten- of toegangsbeheer

    public function getLabel(): string
    {
        return match ($this) {
            self::INCIDENT       => 'Incident',
            self::SERVICEVERZOEK => 'Serviceverzoek',
            self::PROBLEEM       => 'Probleem',
            self::WIJZIGING      => 'Wijziging',
            self::RELEASE        => 'Release',
            self::EVENT          => 'Event',
            self::TOEGANG        => 'Toegang',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::INCIDENT       => 'danger',
            self::SERVICEVERZOEK => 'info',
            self::PROBLEEM       => 'warning',
            self::WIJZIGING      => 'primary',
            self::RELEASE        => 'success',
            self::EVENT          => 'gray',
            self::TOEGANG        => 'secondary',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::INCIDENT       => 'heroicon-o-exclamation-circle',
            self::SERVICEVERZOEK => 'heroicon-o-question-mark-circle',
            self::PROBLEEM       => 'heroicon-o-lightning-bolt',
            self::WIJZIGING      => 'heroicon-o-pencil-square',
            self::RELEASE        => 'heroicon-o-rocket',
            self::EVENT          => 'heroicon-o-bell',
            self::TOEGANG        => 'heroicon-o-key',
        };
    }
}