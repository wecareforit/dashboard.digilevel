<?php

namespace App\Filament\Tenant\Resources\Posts\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use App\Models\User;
use Filament\Schemas\Components\Grid;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(1)
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->string()
                            ->maxLength(256),
                        Textarea::make('body')
                            ->required()
                            ->string()
                            ->maxLength(2048),
                        Select::make('user_id')
                            ->label('Author')
                            ->options(User::query()->pluck('name', 'id'))
                            ->searchable()
                            ->required(),
                    ]),
            ]);
    }
}
