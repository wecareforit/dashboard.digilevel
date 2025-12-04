<?php
namespace App\Filament\Resources\ContactResource\Pages;

use App\Filament\Resources\ContactResource;
use Asmit\ResizedColumn\HasResizableColumn;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;
use Relaticle\CustomFields\Filament\Tables\Concerns\InteractsWithCustomFields;

class ListContacts extends ListRecords
{

    use InteractsWithCustomFields;
    protected static string $resource = ContactResource::class;
    protected static ?string $title   = "Contactpersonen";
    use HasResizableColumn;
    
    public function getHeading(): string
    {
        return "Contact - Overzicht";
    }


    
}
