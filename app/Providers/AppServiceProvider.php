<?php
namespace App\Providers;

//use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;
use App\Policies\ActivityPolicy;
use Filament\Facades\Filament;
use Filament\Navigation\UserMenuItem;
use Filament\Notifications\Livewire\Notifications;
use Filament\Support\Assets\Css;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\VerticalAlignment;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentColor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use SocialiteProviders\Azure\Provider;
use SocialiteProviders\Manager\SocialiteWasCalled;
use Spatie\Activitylog\Models\Activity;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Gate::policy(Activity::class, ActivityPolicy::class);
        // Event::listen(function (\SocialiteProviders\Manager\SocialiteWasCalled $event) {
        //     $event->extendSocialite('azure', \SocialiteProviders\Azure\Provider::class);
        // });
        // LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
        //     $switch
        //         ->locales(['nl', 'en'])

        //         ->flags([
        //             'en' => asset('/images/flags/en.svg'),
        //             'nl' => asset('/images/flags/nl.svg'),
        //         ])->circular()

        //         ->visible(outsidePanels: false);
        //     //->outsidePanelPlacement(Placement::BottomRight);
        // });

        Event::listen(function (SocialiteWasCalled $event) {

            $event->extendSocialite('azure', Provider::class);

        });

        Gate::define('viewApiDocs', function (User $user) {
            return in_array($user->email, ['superadmin@ltssoftware.nl']);
        });

        FilamentAsset::register([
            Css::make('layout', __DIR__ . '/../../resources/css/tenant.css'),
        ]);
        Notifications::verticalAlignment(VerticalAlignment::End);

        FilamentColor::register([
            'primary' => Color::hex('#ff0000'),
        ]);
        Filament::serving(function () {
            Filament::registerUserMenuItems([
                // UserMenuItem::make()
                //     ->label('Instellingen')
                //     ->url(route('filament.admin.general'))
                //     ->icon('heroicon-s-cog'),
                // UserMenuItem::make()
                //     ->label('Logboek')
                //     ->url(route('filament.admin.logs'))
                //     ->icon('heroicon-m-clipboard-document-list'),
                UserMenuItem::make()
                    ->label('Mijn profiel')
                    ->url('/my-profile')
                    ->icon('heroicon-o-user'),

            ]);
        });

        Model::unguard();
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
}
