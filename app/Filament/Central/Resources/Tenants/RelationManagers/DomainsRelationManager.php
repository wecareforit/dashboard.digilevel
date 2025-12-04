<?php

namespace App\Filament\Central\Resources\Tenants\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\TextInput;
use App\DomainManager;
use Illuminate\Support\Str;
use App\Models\Domain;
use Closure;

class DomainsRelationManager extends RelationManager
{
    protected static string $relationship = 'domains';

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                TextInput::make('domain')
                    ->label('Domain')
                    ->placeholder('acme.test')
                    ->required()
                    ->string()
                    ->regex('/^[A-Za-z0-9]+[A-Za-z0-9.-]+[A-Za-z0-9]+$/')
                    ->regex('/\\./')
                    ->unique('central.domains', 'domain')
                    ->rule(function () {
                        return function (string $attribute, $value, Closure $fail) {
                            $tenant = $this->getOwnerRecord();
                            $centralDomain = config('tenancy.identification.central_domains')[0];

                            // Check if domain ends with central domain (except localhost)
                            if ($centralDomain !== 'localhost' && Str::endsWith($value, $centralDomain)) {
                                $fail('The domain must be a custom domain, not ending with the central domain.');
                            }

                            // Check for localhost domain conflicts with fallback
                            if (Str::endsWith($value, '.localhost')) {
                                $subdomain = Str::before($value, '.localhost');
                                if ($tenant->fallback_domain && $tenant->fallback_domain->domain === $subdomain) {
                                    $fail('This localhost domain conflicts with the current fallback domain.');
                                }
                            }
                        };
                    }),
            ]);
    }

    public function fallbackForm(Schema $form): Schema
    {
        return $form
            ->schema([
                TextInput::make('domain')
                    ->label('Subdomain')
                    ->placeholder('acme')
                    ->suffix('.' . config('tenancy.identification.central_domains')[0])
                    ->required()
                    ->string()
                    ->regex('/^[A-Za-z0-9-]+$/')
                    ->helperText('Only letters, numbers, and dashes allowed (no dots)')
                    ->rule(function () {
                        return function (string $attribute, $value, Closure $fail) {
                            $tenant = $this->getOwnerRecord();

                            // Check if it's in reserved subdomains
                            $reserved = config('saas.reserved_subdomains', []);
                            if (in_array($value, $reserved)) {
                                $fail('This subdomain is reserved and cannot be used.');
                            }

                            $oldFallback = $tenant->fallback_domain;
                            if ($value !== $oldFallback->domain) {
                                $exists = Domain::where('domain', $value)->exists();
                                if ($exists) {
                                    $fail('This subdomain is already taken.');
                                }
                            }
                        };
                    }),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('domain')
            ->columns([
                TextColumn::make('domain')
                    ->searchable()
                    ->sortable(),

                IconColumn::make('is_primary')
                    ->boolean()
                    ->label('Primary'),

                IconColumn::make('is_fallback')
                    ->boolean()
                    ->label('Fallback'),

                IconColumn::make('has_certificate')
                    ->boolean()
                    ->label('Certificate')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->headerActions([
                CreateAction::make('createDomain')
                    ->createAnother(false)
                    ->using(function (array $data) {
                        return DomainManager::createDomain($data['domain'], $this->getOwnerRecord());
                    }),
                CreateAction::make('storeFallback')
                    ->createAnother(false)
                    ->label('Update fallback subdomain')
                    ->modalHeading('Update fallback subdomain')
                    ->modalSubmitActionLabel('Update')
                    ->successNotificationTitle('Updated.')
                    ->icon('heroicon-o-star')
                    ->schema(fn (Schema $form) => $this->fallbackForm($form)->getComponents())
                    ->using(function (array $data) {
                        return DomainManager::storeFallback($data['domain'], $this->getOwnerRecord());
                    })
            ])
            ->recordActions([
                ActionGroup::make([
                    Action::make('makePrimary')
                        ->label('Make Primary')
                        ->icon('heroicon-o-star')
                        ->action(fn (Domain $record) => DomainManager::makePrimary($record))
                        ->visible(fn (Domain $record) => ! $record->is_primary),

                    Action::make('requestCertificate')
                        ->label('Request Certificate')
                        ->icon('heroicon-o-lock-closed')
                        ->requiresConfirmation()
                        ->action(fn (Domain $record) => DomainManager::requestCertificate($record))
                        ->visible(fn (Domain $record) => $record->certificate_status !== 'issued'),

                    Action::make('revokeCertificate')
                        ->label('Revoke Certificate')
                        ->icon('heroicon-o-lock-open')
                        ->requiresConfirmation()
                        ->color('danger')
                        ->action(fn (Domain $record) => DomainManager::revokeCertificate($record))
                        ->visible(fn (Domain $record) => $record->certificate_status === 'issued'),

                    DeleteAction::make()
                        ->visible(fn (Domain $record) => ! $record->is_fallback && ! $record->is_primary),
                    ])
                    ->icon('heroicon-m-ellipsis-vertical')
                    ->size('sm')
                    ->color('gray')
                    ->button(),
            ]);
    }
}
