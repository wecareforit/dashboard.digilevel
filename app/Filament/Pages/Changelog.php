<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Changelog extends Page
{
    protected static ?string $slug = 'changelog';
    protected static string $view = 'filament.pages.changelog';
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static bool $shouldRegisterNavigation = false;

    public function getHeading(): string 
    {
        return __('Changelog');
    }

    protected function getViewData(): array
    {
        return [
            'changelogEntries' => [
                [
                    'version' => 'v1.2.0',
                    'date' => now()->subDays(10)->format('Y-m-d'),
                    'changes' => [
                        __('New dashboard interface'),
                        __('Performance improvements'),
                        __('Export functionality fixes')
                    ]
                ],
                // Add more entries as needed
            ]
        ];
    }
}