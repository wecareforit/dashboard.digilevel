<?php

namespace App\Filament\Central\Resources\Tenants\Pages;

use App\Filament\Central\Resources\Tenants\TenantResource;
use App\Actions\CreateTenantAction;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class CreateTenant extends CreateRecord
{
    protected static string $resource = TenantResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $data['password'] = bcrypt($data['password']);

        $domain = $data['domain'] ?? null;
        unset($data['domain']);

        return (new CreateTenantAction)($data, $domain);
    }

    protected function getFormValidationRules(): array
    {
        return [
            'domain' => [
                'required',
                'string',
                'unique:domains',
                Rule::notIn(config('saas.reserved_subdomains')),
                'regex:/^[A-Za-z0-9-]+$/',
            ],
            'company' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:tenants',
            'password' => 'required|string|confirmed|max:255',
        ];
    }

    protected function getFormValidationMessages(): array
    {
        return [
            'domain.regex' => 'The subdomain may only contain letters, numbers, and dashes.',
            'domain.unique' => 'This subdomain is already taken.',
            'domain.not_in' => 'This subdomain is reserved and cannot be used.',
            'email.unique' => 'A tenant with this email already exists.',
            'password.confirmed' => 'The password confirmation does not match.',
        ];
    }
}
