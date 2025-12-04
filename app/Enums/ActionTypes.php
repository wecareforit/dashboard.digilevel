<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ActionTypes: string implements HasLabel {
    case CALLBACK = "1";
    case CHECKPUNT = "2";
    case TODO = "3";

    public function getlabel(): string
    {
        return match ($this) {
            self::CALLBACK => 'Terugbelnotitie',
            self::CHECKPUNT => 'Keuringspunten',
            self::TODO => 'Te doen',
            //     self::NOT_COMPLETED => 'Niet afgrond',
            //     self::APPROVED_REPEAT => 'Goedgekeurd met herhaalpunten',
        };
    }

    public function HasLabel(): string
    {
        return match ($this) {
            self::CALLBACK => 'Terugbelnotitie',
            self::CHECKPUNT => 'Keuringspunten',
            self::TODO => 'Te doen',

            //     self::NOT_COMPLETED => 'Niet afgrond',
            //     self::APPROVED_REPEAT => 'Goedgekeurd met herhaalpunten',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }

    // public function getIcon(): ?string
    // {
    //     return match ($this) {
    //         self::EXTERN => 'heroicon-o-cpu-chip',
    //         self::INTERN => 'heroicon-m-check'
    //     };
    // }

    // public function getColor(): string | array | null
    // {
    //     return match ($this) {
    //         self::TYPE01 => 'success',
    //         self::TYPE02 => 'success',
    //         self::TYPE03 => 'danger',
    //         self::TYPE04 => 'warning',

    //     };
    // }
}
