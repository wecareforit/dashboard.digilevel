<?php

namespace App\Filament\Central\Resources\Tenants\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\DeleteAction;
use Filament\Tables\Filters\Filter;
use App\Models\Tenant;

class TenantsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('email')
                    ->label('Email')
                    ->sortable()
                    ->searchable()
                    ->copyable(),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->state(fn (Tenant $record): string => $record->pending() ? 'Pending' : 'Live')
                    ->color(fn (Tenant $record): string => $record->pending() ? 'warning' : 'success')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordUrl(fn (Tenant $record) => $record->pending() ? null : route('filament.admin.resources.tenants.edit', $record))
            ->filters([
                Filter::make('status')
                    ->label('Hide pending')
                    ->query(fn ($query) => $query->withoutPending())
                    ->toggle()
                    ->default(),
            ])
            ->recordActions([
                EditAction::make()
                    ->disabled(fn (Tenant $record) => $record->pending())
                    ->tooltip(fn (Tenant $record) => $record->pending() ? 'Cannot edit pending tenant.' : null),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
