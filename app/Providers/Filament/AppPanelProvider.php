<?php
namespace App\Providers\Filament;
use App\Models\Company;
 
use Filament\Navigation\MenuItem;
use App\Filament\Pages\Tenancy\RegisterCompany;
use Filament\Http\Middleware\Authenticate;
//use lockscreen\FilamentLockscreen\Lockscreen;
//use lockscreen\FilamentLockscreen\Http\Middleware\Locker;
//use lockscreen\FilamentLockscreen\Http\Middleware\LockerTimer;

use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Laravel\Socialite\Contracts\User as SocialiteUserContract;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
 use DutchCodingCompany\FilamentSocialite\FilamentSocialitePlugin;
use DutchCodingCompany\FilamentSocialite\Provider;
use Filament\Support\Enums\MaxWidth;
use Carbon\Carbon;
//use Niladam\FilamentAutoLogout\AutoLogoutPlugin;
 use lockscreen\FilamentLockscreen\Lockscreen;
use lockscreen\FilamentLockscreen\Http\Middleware\Locker;
use lockscreen\FilamentLockscreen\Http\Middleware\LockerTimer;
use Swis\Filament\Backgrounds\FilamentBackgroundsPlugin;
use Stephenjude\FilamentTwoFactorAuthentication\TwoFactorAuthenticationPlugin;
use Swis\Filament\Backgrounds\ImageProviders\MyImages;
use Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin;
use Rupadana\ApiService\ApiServicePlugin;
use Tapp\FilamentAuthenticationLog\FilamentAuthenticationLogPlugin;
 use Devonab\FilamentEasyFooter\EasyFooterPlugin;
use DutchCodingCompany\FilamentDeveloperLogins\FilamentDeveloperLoginsPlugin;
use Filament\Enums\ThemeMode;
use MartinPetricko\FilamentSentryFeedback\Entities\SentryUser;
use Relaticle\CustomFields\CustomFieldsPlugin;
use Asmit\ResizedColumn\ResizedColumnPlugin;
use Joaopaulolndev\FilamentEditProfile\Pages\EditProfilePage;
use CharrafiMed\GlobalSearchModal\GlobalSearchModalPlugin;
class AppPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel


    ->plugins([
            // ... other plugins
            ResizedColumnPlugin::make()
                ->preserveOnDB(true) // Enable database storage (optional),

 
        ])


    ->plugins([
     

   GlobalSearchModalPlugin::make()
        ])
      ->globalSearchKeyBindings(['command+k', 'ctrl+k'])

           ->defaultThemeMode(ThemeMode::Light)
->darkMode(false)
->default()


->plugins([
    \MartinPetricko\FilamentSentryFeedback\FilamentSentryFeedbackPlugin::make()
        ->sentryUser(function (): ?SentryUser {
            return new SentryUser(auth()->user()?->name, auth()?->user()?->email);
        }),
])



            ->id('app')


    ->plugins([
            CustomFieldsPlugin::make(),
        ])


->plugins([
    ApiServicePlugin::make()
])
->plugins([
    \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make()
->gridColumns([
                        'default' => 2,
                        'sm' => 2,
                        'lg' => 2
                    ])
                    ->sectionColumnSpan(1)
                    ->checkboxListColumns([
                        'default' => 1,
                        'sm' => 2,
                        'lg' => 4,
                    ])
                    ->resourceCheckboxListColumns([
                        'default' => 1,
                        'sm' => 2,
                    ]),
 
//  FilamentAuthenticationLogPlugin::make()
])->passwordReset()
 
 ->favicon(asset('/images/ico.png')) 

 
// ->plugins([
//     EasyFooterPlugin::make()
//    ->withLogo(
//             '/images/ico.png', // Path to logo
//             'https://www.kwimbi.nll'                                // URL for logo link (optional)
//         )
//  ->withFooterPosition('sidebar.footer'),
// ])


->plugins([

 FilamentEditProfilePlugin::make()
        ->slug('my-profile')
        ->setTitle('Mijn profiel')
        ->setNavigationLabel('My Profile')
        ->setNavigationGroup('Group Profile')
        ->setIcon('heroicon-o-user')
        ->setSort(10)
        ->shouldRegisterNavigation(false)
        ->shouldShowDeleteAccountForm(false)
        ->shouldShowBrowserSessionsForm(true)
        ->shouldShowAvatarForm(),
 
        FilamentDeveloperLoginsPlugin::make()
        ->enabled(app()->environment('local'))
        ->switchable(false)
 

        ->users([
            'Admin' => 'superAdmin@ltssoftware.nl',
        ]),
        ])

 


//->plugin(\TomatoPHP\FilamentPWA\FilamentPWAPlugin::make())

  // ->plugins([
         //   TwoFactorAuthenticationPlugin::make()
                 //   ->addTwoFactorMenuItem() // Add 2FA settings to user menu items

      //  ])
->plugin(new Lockscreen())   // <- Add this
 


 //->plugins([
          //  FilamentBackgroundsPlugin::make()
            //    ->imageProvider(
               //     MyImages::make()
                //        ->directory('images/backgrounds')
               // ),
     //   ])

 //->plugin(\TomatoPHP\FilamentPWA\FilamentPWAPlugin::make())
            ->path('')
   	
            ->maxContentWidth(MaxWidth::Full)
  ->sidebarCollapsibleOnDesktop(false)
 
            ->breadcrumbs(true)
 ->plugins([
              


FilamentSocialitePlugin::make()
                    ->providers([
                        Provider::make('azure'),
                    ])
                     ->createUserUsing(fn (string $provider, User $oauthUser, FilamentSocialitePlugin $plugin) => User::create([
                        'first_name' => $oauthUser->user['givenName'],
                        'last_name' => $oauthUser->user['surname'],
                        'email' => $oauthUser->getEmail(),
                    ]))
                    ->registration(true),
          


        
                    ]) 
 
 
   ->topNavigation(setting('portal_menu_position') ?? false) 
 

    ->readOnlyRelationManagersOnResourceViewPagesByDefault(false)
            ->login()
     ->brandLogo(fn() => view('components.logo'))
            ->colors([
                'primary' => Color::Amber,
            ])      ->plugin(
            \Hasnayeen\Themes\ThemesPlugin::make()
        )    ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                
            ])
           ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
              
            ])
// ->plugin(new Lockscreen())
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
   \Hasnayeen\Themes\Http\Middleware\SetTheme::class,
       //
              

 
                DispatchServingFilamentEvent::class,
            ])   ->authMiddleware([
                // ...
              Locker::class, // <- Add this
            ])
// ->tenantMiddleware([
     //                 \Hasnayeen\Themes\Http\Middleware\SetTheme::class
     //   ], isPersistent: true)
            ->authMiddleware([
                Authenticate::class,
            ])



->userMenuItems([

 
])

;
    }
}
