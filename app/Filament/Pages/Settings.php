<?php
namespace App\Filament\Pages;

use Filament\Pages\Page;

class Settings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $view                   = 'filament.pages.settings';
    protected static ?string $navigationLabel       = "Instellingen";
    protected static ?string $modelLabel            = 'Instellingen';
    protected static ?string $pluralModelLabel      = 'Instellingen';
    protected static ?string $title                 = "Instellingen";
    protected static bool $shouldRegisterNavigation = false;

}
