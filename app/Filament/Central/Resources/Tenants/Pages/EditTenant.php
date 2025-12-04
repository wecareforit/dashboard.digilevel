<?php

namespace App\Filament\Central\Resources\Tenants\Pages;

use App\BillingManager;
use App\Filament\Central\Resources\Tenants\Actions\ImpersonateTenantAction;
use App\Filament\Central\Resources\Tenants\Schemas\EditTenantForm;
use App\Filament\Central\Resources\Tenants\TenantResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Schema;

class EditTenant extends EditRecord
{
    protected static string $resource = TenantResource::class;

    public function form(Schema $schema): Schema
    {
        abort_if($schema->getRecord()->pending(), 403);

        return EditTenantForm::configure($schema, $this);
    }

    /**
     * Returning an empty array here prevents rendering
     * the domains relationship manager below the form.
     * Instead, we include the domain manager in a tab.
     *
     * @see App\Filament\Central\Resources\Tenants\Schemas\Components\DomainManagementTab
     */
    public function getRelationManagers(): array
    {
        return [];
    }

    protected function getHeaderActions(): array
    {
        return [
            ImpersonateTenantAction::make(),
            DeleteAction::make(),
        ];
    }

    /**
     * Returning an empty array here prevents rendering
     * the default (save and cancel) actions from being rendered on the edit page.
     * Instead, the actions are included in the tab sections.
     *
     * Tabs have their inner sections with their own actions.
     * E.g. BillingManagementTab has BillingAddressSection and CreditBalanceSection.
     * Both sections have their own actions.
     *
     * @see App\Filament\Central\Resources\Tenants\Schemas\Components\BillingManagementTab
     * @see App\Filament\Central\Resources\Tenants\Schemas\Components\BillingAddressSection
     * @see App\Filament\Central\Resources\Tenants\Schemas\Components\CreditBalanceSection
     */
    protected function getFormActions(): array
    {
        return [];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Add billing address if available
        if (BillingManager::tenantCanUseStripe($this->record)) {
            $address = $this->record->asStripeCustomer()?->address;

            if ($address) {
                $data = array_merge($data, $address->toArray());
            }
        }

        return $data;
    }
}
