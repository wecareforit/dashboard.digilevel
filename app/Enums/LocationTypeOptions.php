<?php
namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum LocationTypeOptions: string implements HasLabel {
    case IMAGES      = '1';
    case NOTES       = '2';
    case ATTACHMENTS = '3';
    case OBJECTS     = '4';
    case CONTACTS    = '5';
    case MANAGEMENT  = '6';

    public function getlabel(): string
    {
        return match ($this) {
            self::IMAGES => 'Afbeeldingen',
            self::NOTES => 'Notities',
            self::ATTACHMENTS => 'Bijlages',
            self::OBJECTS => 'Objecten',
            self::CONTACTS => 'Contactpersonen',
            self::MANAGEMENT => 'Beheerder'

        };
    }

}
