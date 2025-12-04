<?php

declare(strict_types=1);

use App\Filament\Central\Resources\Tenants\Pages\CreateTenant;
use App\Filament\Central\Resources\Tenants\Pages\ListTenants;
use Filament\Actions\Testing\TestAction;
use App\Filament\Central\Resources\Tenants\TenantResource;
use Livewire\Livewire;
use App\Models\Admin;
use App\Models\Tenant;
use App\Filament\Central\Resources\Tenants\Pages\EditTenant;
use Illuminate\Support\Str;
use App\DomainManager;
use App\Models\Domain;
use App\Filament\Central\Resources\Tenants\RelationManagers\DomainsRelationManager;

test('admin panel can be accessed by admin users', function () {
    // Guests are redirected to login
    $this->get(TenantResource::getUrl())
        ->assertRedirect(route('admin.login'));

    $admin = Admin::create([
        'name' => 'Admin User',
        'email' => 'admin@localhost.test',
        'password' => 'password',
    ]);

    $this->actingAs($admin)
        ->get(TenantResource::getUrl())
        ->assertSuccessful();
});

test('the admin tenants index route redirects to the tenant resource', function() {
    $admin = Admin::create([
        'name' => 'Admin User',
        'email' => 'admin@localhost.test',
        'password' => 'password',
    ]);

    $this->actingAs($admin)
        ->get(route('admin.tenants.index'))
        ->assertRedirect(TenantResource::getUrl());
});

test('tenant resource pages are accessible', function() {
    $admin = Admin::create([
        'name' => 'Admin User',
        'email' => 'admin@localhost.test',
        'password' => 'password',
    ]);

    $this->actingAs($admin);

    $this->get(ListTenants::getUrl())
        ->assertOk();

    $this->get(CreateTenant::getUrl())
        ->assertOk();

    $this->get(EditTenant::getUrl([
        'record' => $this->createTenant(['email' => 'foo@admin.test'])
    ]))->assertOk();
});

test('tenants are listed correctly in the admin panel', function () {
    $tenants = [$this->createTenant(['email' => 'foo@admin.test']), $this->createTenant(['email' => 'bar@admin.test'])];

    Livewire::test(ListTenants::class)
        ->assertCanSeeTableRecords($tenants) // All live tenants are listed (pending tenants are filtered out by default)
        ->assertCountTableRecords(2);
});

test('tenants can be created through admin panel', function () {
    Livewire::test(CreateTenant::class)
        ->fillForm([
            'domain' => 'subdomain',
            'company' => 'New tenant company',
            'name' => 'New tenant name',
            'email' => $email = 'new@tenant.test',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    // Tenant got created
    expect(Tenant::firstWhere('email', $email))->not()->toBeNull();
});

test('tenants can be deleted through admin panel', function () {
    $tenant = $this->createTenant(['email' => 'foo@admin.test', 'company' => 'acme']);

    Livewire::test(ListTenants::class)
        ->assertActionVisible(TestAction::make('delete')->table($tenant))
        ->callAction(TestAction::make('delete')->table($tenant))
        ->assertSuccessful();

    expect(Tenant::find($tenant->id))->toBeNull();
});

test('admin can impersonate tenant through the edit tenant page', function() {
    $tenant = $this->createTenant(['email' => 'foo@admin.test', 'company' => 'acme']);

    Livewire::test(EditTenant::class, ['record' => $tenant->id])
        ->callAction(TestAction::make('impersonate'))
        ->assertHasNoFormErrors()
        ->assertRedirect()
        // We can't check the full URL because the last segment is different on each impersonationUrl() call
        ->assertRedirectContains(Str::beforeLast($tenant->impersonationUrl($tenant->getAdmin()->id), '/'));
});

test('tenant info can be edited through admin panel', function () {
    $tenant = $this->createTenant(['email' => 'foo@admin.test', 'company' => 'acme']);

    Livewire::test(EditTenant::class, ['record' => $tenant->id])
        ->fillForm(['company' => 'new company name'])
        ->callAction(TestAction::make('save_info')->schemaComponent('tenant_info_actions'))
        ->assertHasNoFormErrors();

    expect($tenant->refresh()->company)->toBe('new company name');
});

test('billing address can be edited through admin panel', function () {
    $tenant = $this->createTenant(['email' => 'foo@admin.test', 'company' => 'acme']);

    expect($tenant->asStripeCustomer()->address)->toBeNull();

    Livewire::test(EditTenant::class, ['record' => $tenant->id])
        ->fillForm($newBillingAddress = [
            'line1' => 'foo',
            'line2' => 'bar',
            'city' => 'some city',
            'state' => 'some state',
            'country' => 'US',
            'postal_code' => '10001',
        ])
        ->callAction(TestAction::make('save_billing_address')->schemaComponent('billing_address_actions'))
        ->assertHasNoFormErrors();

    expect($tenant->asStripeCustomer()->address->toArray())->toEqual($newBillingAddress);
})->skip(fn () => ! env('STRIPE_KEY'));

test('credit balance can be adjusted through admin panel', function () {
    $tenant = $this->createTenant(['email' => 'foo@admin.test', 'company' => 'acme']);

    expect($tenant->asStripeCustomer()->address)->toBeNull();

    Livewire::test(EditTenant::class, ['record' => $tenant->id])
        ->fillForm(['credit_balance_adjustment' => '500.50'])
        ->callAction(TestAction::make('adjust_credit_balance')->schemaComponent('credit_balance_actions'))
        ->assertHasNoFormErrors();

    expect($tenant->getCreditBalance(returnFormatted: false)['amount'])->toBe(50050);
})->skip(fn () => ! env('STRIPE_KEY'));

// Domains
test('domain manager is on the edit tenant page', function() {
    $tenant = $this->createTenant(['email' => 'foo@admin.test', 'company' => 'acme']);

    Livewire::test(EditTenant::class, ['record' => $tenant->id])
        ->assertSeeLivewire(DomainsRelationManager::class);
});

test('domain manager lists domains correctly', function () {
    // Create tenant with domain (that's primary and fallback)
    $tenant = $this->createTenant(['email' => 'foo@admin.test', 'company' => 'acme']);

    // Add another domain (2 domains in total now)
    DomainManager::createDomain('newdomain.test', $tenant);

    Livewire::test(DomainsRelationManager::class, [
        'ownerRecord' => $tenant,
        'pageClass' => EditTenant::class,
    ])->assertOk()
        ->assertCanSeeTableRecords($tenant->domains)
        ->assertCountTableRecords(2);
});

test('domains can be created using the domain manager', function() {
    $tenant = $this->createTenant(['email' => 'foo@admin.test', 'company' => 'acme']);

    Livewire::test(DomainsRelationManager::class, [
        'ownerRecord' => $tenant,
        'pageClass' => EditTenant::class,
    ])->callAction(TestAction::make('createDomain')->table(), ['domain' => 'newdomain.test'])
        ->assertHasNoFormErrors();

    expect(Domain::firstWhere('domain', 'newdomain.test'))->not()->toBeNull();
});

test('domains can be deleted using the domain manager', function() {
    $tenant = $this->createTenant(['email' => 'foo@admin.test', 'company' => 'acme']);

    $domain = DomainManager::createDomain('deleteme.test', $tenant);

    Livewire::test(DomainsRelationManager::class, [
        'ownerRecord' => $tenant,
        'pageClass' => EditTenant::class,
    ])
        ->callAction(TestAction::make('delete')->table($domain))
        ->assertHasNoFormErrors();

    expect(Domain::find($domain->id))->toBeNull();
});

test('making domains primary using the domain manager works correctly', function() {
    $tenant = $this->createTenant(['email' => 'foo@admin.test', 'company' => 'acme']);

    // Create a secondary domain
    $newDomain = DomainManager::createDomain('newprimary.test', $tenant);
    $newDomain->refresh(); // Refresh to get is_primary attribute
    $oldPrimary = $tenant->refresh()->primary_domain;

    expect($oldPrimary->is_primary)->toBeTrue();
    expect($newDomain->is_primary)->toBeFalse();

    Livewire::test(DomainsRelationManager::class, [
        'ownerRecord' => $tenant,
        'pageClass' => EditTenant::class,
    ])
        ->callAction(TestAction::make('makePrimary')->table($newDomain))
        ->assertHasNoFormErrors();

    // The new domain is now primary
    expect($newDomain->refresh()->is_primary)->toBeTrue();
    // The old primary domain is not primary anymore
    expect($oldPrimary->refresh()->is_primary)->toBeFalse();
});

test('fallback domain can be updated using the domain manager', function() {
    $tenant = $this->createTenant(['email' => 'foo@admin.test', 'company' => 'acme']);

    $oldFallback = $tenant->fallback_domain;

    Livewire::test(DomainsRelationManager::class, [
        'ownerRecord' => $tenant,
        'pageClass' => EditTenant::class,
    ])
        ->callAction(TestAction::make('storeFallback')->table(), ['domain' => 'newfallback'])
        ->assertHasNoFormErrors();

    // Old fallback domain got deleted
    expect(Domain::find($oldFallback->id))->toBeNull();

    // New fallback got created
    $newFallback = $tenant->refresh()->fallback_domain;
    expect($newFallback->domain)->toBe('newfallback');
    expect($newFallback->is_fallback)->toBeTrue();
});
