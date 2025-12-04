<?PHP
namespace App\Filament\Pages;

use App\Models\locationType;
use App\Models\relationType;
use App\Models\tenantSetting;
use App\Models\workorderActivities;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Database\Eloquent\Model;

class TenantSettings extends Page implements HasForms
{

    use InteractsWithForms;

    protected static ?string $navigationIcon        = 'heroicon-o-cog';
    protected static string $view                   = 'filament.pages.tenant-settings';
    protected static ?string $navigationLabel       = 'Settings';
    protected static bool $shouldRegisterNavigation = false;
    public $inspection_relation_group;
    public $object_supplier_group;
    public $use_projects;
    public $use_timetracking;
    public $use_inspections;
    public $use_locations;
    public $use_tickets;

    public $use_vehiclemanagement;
    public $use_gps_tracker;
    public $use_api_connection;
    public $use_workorders;
    public $use_company_locations;
    public $use_company_warehouses;
    public $use_company_departments;
    public $use_company_spaces;
    public $color1;
    public $color2;
    public $company_logo;
    public $company_favo_logo;
    public $company_name;
    public $portal_menu_position;

    public $mail_mailer;
    public $mail_host;
    public $mail_port;

    public $mail_username;
    public $mail_password;
    public $mail_from_address;
    public $mail_from_name;
    public $mail_encryption;
    public $management_relation_group;
    public $tasks_in_location;
    public $default_parent_location;
    public $environment_elevator;
    public $upload_path;
    public $module_elevators;

    public $default_hourtype_timeregistration;
    public function mount(): void
    {
        $this->form->fill([
            'object_supplier_group'             => $this->getSetting('object_supplier_group'),
            'seo_title'                         => $this->getSetting('seo_title'),
            'use_projects'                      => $this->getSetting('use_projects') ?? false,
            'use_timetracking'                  => $this->getSetting('use_timetracking'),
            'use_inspections'                   => $this->getSetting('use_inspections'),
            'use_locations'                     => $this->getSetting('use_locations'),
            'use_tickets'                       => $this->getSetting('use_tickets'),
            'use_vehiclemanagement'             => $this->getSetting('use_vehiclemanagement'),
            'use_gps_tracker'                   => $this->getSetting('use_gps_tracker'),
            'use_api_connection'                => $this->getSetting('use_api_connection'),
            'use_workorders'                    => $this->getSetting('use_workorders'),
            'inspection_relation_group'         => $this->getSetting('inspection_relation_group'),
            'use_company_departments'           => $this->getSetting('use_company_departments'),
            'use_company_locations'             => $this->getSetting('use_company_locations'),
            'use_company_warehouses'            => $this->getSetting('use_company_warehouses'),
            'use_company_spaces'                => $this->getSetting('use_company_spaces'),
            'color1'                            => $this->getSetting('color1'),
            'color2'                            => $this->getSetting('color2'),
            'company_logo'                      => $this->getSetting('company_logo'),
            'company_favo_logo'                 => $this->getSetting('company_favo_logo'),
            'company_name'                      => $this->getSetting('company_name'),
            'portal_menu_position'              => $this->getSetting('portal_menu_position'),

            'mail_mailer'                       => $this->getSetting('mail_mailer'),
            'mail_host'                         => $this->getSetting('mail_host'),
            'mail_port'                         => $this->getSetting('mail_port'),
            'mail_username'                     => $this->getSetting('mail_username'),

            'mail_username'                     => $this->getSetting('mail_username'),
            'mail_password'                     => $this->getSetting('mail_password'),
            'mail_from_address'                 => $this->getSetting('mail_from_address'),
            'mail_from_name'                    => $this->getSetting('mail_from_name'),
            'mail_encryption'                   => $this->getSetting('mail_encryption'),
            'management_relation_group'         => $this->getSetting('management_relation_group'),
            'default_hourtype_timeregistration' => $this->getSetting('default_hourtype_timeregistration'),
            'default_parent_location'           => $this->getSetting('default_parent_location'),
            'upload_path'                       => $this->getSetting('upload_path'),
            'module_elevators'                  => $this->getSetting('module_elevators'),


        ]);
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Tabs::make('Settings')
                ->tabs([

                    Forms\Components\Tabs\Tab::make('Bedrijfsinformatie')

                        ->schema([
                            TextInput::make('company_name')
                                ->label('Bedrijfsnaam'),
                        ]),

                    Forms\Components\Tabs\Tab::make('Modules')

                        ->schema([

                            Section::make('environment')
                                ->visible(fn() => auth()->id() === 1)
                                ->label('omgevingsinstellingen')
                                ->columns(4)
                                ->schema([

                                    TextInput::make('upload_path')
                                        ->label('Upload path'),

                               

                                ]),

                            Section::make('Objecten')
                                ->columns(4)
                                ->schema([

                                    ToggleButtons::make('use_inspections')
                                        ->label('Keuringen')
                                        ->boolean()
                                        ->inline(),

                                ]),
                            Section::make('Algemeen')
                                ->columns(4)
                                ->schema([

                                    ToggleButtons::make('use_projects')
                                        ->label('Projecten')
                                        ->boolean()
                                        ->default(false)
                                        ->inline(),

                                    ToggleButtons::make('use_timetracking')
                                        ->label('Tijdregistratie')
                                        ->boolean()
                                        ->inline(),

                                    ToggleButtons::make('use_locations')
                                        ->label('Locaties')
                                        ->boolean()
                                        ->inline(),

                                    ToggleButtons::make('use_tickets')
                                        ->label('Tickets')
                                        ->boolean()
                                        ->inline(),

                                    ToggleButtons::make('use_vehiclemanagement')
                                        ->label('Voortuigbeheer')
                                        ->boolean()
                                        ->inline(),


                                    ToggleButtons::make('module_elevators')
                                        ->label('Liften module')
                                        ->boolean()
                                        ->inline(),



                                    ToggleButtons::make('use_gps_tracker')
                                        ->label('Voortuig GPS Tracker')
                                        ->boolean()
                                        ->inline(),

                                    ToggleButtons::make('use_api_connection')
                                        ->label('API Verbinding')
                                        ->boolean()
                                        ->inline(),

                                    ToggleButtons::make('use_workorders')
                                        ->label('Werkbonnen')
                                        ->boolean()
                                        ->inline(),
                                ])

                            , Section::make('Mijn bedijf')
                                ->columns(4)
                                ->schema([

                                    ToggleButtons::make('use_company_spaces')
                                        ->label('Ruimes')
                                        ->boolean()
                                        ->inline(),

                                    ToggleButtons::make('use_company_departments')
                                        ->label('Afdelingen')
                                        ->boolean()
                                        ->inline(),

                                    ToggleButtons::make('use_company_locations')
                                        ->label('Locaties')
                                        ->boolean()
                                        ->inline(),

                                    ToggleButtons::make('use_company_warehouses')
                                        ->label('Magazijnen')
                                        ->boolean()
                                        ->inline(),

                                ]),

                        ]),

                    Forms\Components\Tabs\Tab::make('Relatie categorieen')
                        ->schema([

                            Section::make()
                                ->columns(4)
                                ->schema([

                                    Forms\Components\Select::make('default_hourtype_timeregistration')
                                        ->label('Standaard uurtype tijdregistratie')
                                        ->options(workorderActivities::pluck('name', 'id')),

                                ])->description('Selecteer standaard relatie categorieen per onderdeel'),

                            Section::make()
                                ->columns(4)
                                ->schema([

                                    Forms\Components\Select::make('object_supplier_group')
                                        ->label('Objecten')
                                        ->options(relationType::pluck('name', 'id')),

                                    Forms\Components\Select::make('inspection_relation_group')
                                        ->label('Keuringen')
                                        ->options(relationType::pluck('name', 'id')),

                                    Forms\Components\Select::make('management_relation_group')
                                        ->label('Beheerder')
                                        ->options(relationType::pluck('name', 'id')),

                                    Forms\Components\Select::make('default_parent_location')
                                        ->label('Standaard hoofdlocatie')
                                        ->options(locationType::pluck('name', 'id')),

                                ])->description('Selecteer standaard relatie categorieen per onderdeel'),

                        ]),

                    Forms\Components\Tabs\Tab::make('Vormgeving')

                        ->schema([

                            Section::make()

                                ->columns(4)
                                ->schema([
                                    Forms\Components\Select::make('portal_menu_position')
                                        ->label('Menu positie')
                                        ->options([
                                            '1' => "Boven",
                                            '0' => "Links",
                                        ])
                                    ,

                                ]),

                            Section::make('Kleuren')
                                ->columns(4)
                                ->schema([
                                    Forms\Components\ColorPicker::make('color2')
                                        ->label('Kleur 1')
                                        ->hint('Bovenbalk links')
                                        ->required(),
                                    Forms\Components\ColorPicker::make('color1')
                                        ->label('Kleur 2')
                                        ->hint('Bovenbalk rechts')
                                        ->required(),

                                ]),

                            Section::make('Logo\'s')
                                ->columns(2)
                                ->schema([
                                    FileUpload::make('company_logo')
                                        ->image()

                                        ->label('Bedrijfslogo')
                                        ->imageEditor()
                                        ->helperText('Upload hier het logo dat we moeten tonen in je portaal. Wij adviseren een png-afbeelding met een formaat van 330 x 65 pixels, indien je logo groter is zullen wij deze verkleinen. Wanneer je geen eigen logo upload wordt het logo van Desknow getoond. Max 2MB.')
                                        ->imageEditorAspectRatios([
                                            null,
                                            '16:9',
                                            '4:3',
                                            '1:1',
                                        ]),
                                    FileUpload::make('company_favo_logo')

                                        ->image()
                                        ->label('Favo icon')
                                        ->helperText('Upload een icoon die wordt getoond in het tab van de browser. Wij adviseren een png-afbeelding met een formaat van 32 x 32 pixels. Max. 1MB')
                                        ->imageEditor()
                                        ->imageEditorAspectRatios([
                                            null,
                                            '16:9',
                                            '4:3',
                                            '1:1',
                                        ]),

                                ]),

                        ]),

                    Forms\Components\Tabs\Tab::make('Mail configuratie')

                        ->schema([

                            Section::make('Mail configuratie')
                                ->description('Indien je een eigen mail-server instelt, zal Desknow alleen nog e-mails versturen via deze mail configuratie')

                                ->columns(2)

                                ->schema([

                                    Forms\Components\TextInput::make('mail_mailer')
                                        ->label('Mailer') // Optional: could also be 'Mailverzender'
                                        ->default('smtp')
                                        ->disabled(),

                                    Forms\Components\TextInput::make('mail_host')
                                        ->label('Mail Host'), // Could also be 'Serveradres',

                                    Forms\Components\Select::make('mail_port')
                                        ->label('Mailpoort')
                                        ->options([
                                            '25'  => '25 - Standaard SMTP (onversleuteld)',
                                            '465' => '465 - SMTP via SSL (SMTPS)',
                                            '587' => '587 - SMTP met STARTTLS',
                                        ]),

                                    Forms\Components\TextInput::make('mail_username')
                                        ->label('Gebruikersnaam'),

                                    Forms\Components\TextInput::make('mail_password')
                                        ->label('Wachtwoord')
                                        ->password(),

                                    Forms\Components\Select::make('mail_encryption')
                                        ->label('Versleuteling')
                                        ->options([
                                            'tls' => 'TLS (aanbevolen)',
                                            'ssl' => 'SSL (oudere methode)',
                                            ''    => 'Geen versleuteling',
                                        ])
                                        ->default('tls'),

                                    Forms\Components\TextInput::make('mail_from_address')
                                        ->label('Van-adres')
                                        ->email(),

                                    Forms\Components\TextInput::make('mail_from_name')
                                        ->label('Naam afzender'),
                                ]),

                        ]),

                    Forms\Components\Tabs\Tab::make('Opties')

                        ->schema([
                            ToggleButtons::make('tasks_in_location')
                                ->label('Taak koppelen aan locatie')
                                ->boolean()
                                ->inline(),
                        ]),

                ]),

        ];
    }

    protected function getFormModel(): Model | string | null
    {
        return tenantSetting::first(); // or findOrFail($id), etc.
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            tenantSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        Notification::make()
            ->title('Instellingen opgeslagen')
            ->success()
            ->send();
        //   redirect(request()->header('Referer'));
    }

    private function getSetting($key)
    {
        return tenantSetting::where('key', $key)->value('value') ?? '';
    }
}
