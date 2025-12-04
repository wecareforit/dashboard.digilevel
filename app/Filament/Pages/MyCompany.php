<?php
namespace App\Filament\Pages;

use Filament\Pages\Page;

class MyCompany extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view                   = 'filament.pages.my-company';
    protected static ?string $navigationLabel       = "Mijn bedrijf";
    protected static ?string $modelLabel            = 'Mijn bedrijf';
    protected static ?string $pluralModelLabel      = 'Mijn bedrijf';
    protected static ?string $title                 = "Mijn bedrijf";
    protected static bool $shouldRegisterNavigation = false;

}
