@php
    use Filament\Support\Enums\MaxWidth;
@endphp


<div>
    <x-filament-panels::page.simple >
        @props([
            'after' => null,
            'heading' => null,
            'subheading' => null,
        ])

        <div class="fi-simple-layout flex min-h-screen flex-col items-center">
            <div
                class="fi-simple-main-ctn flex w-full flex-grow items-center justify-center"
            >
            <main
                @class([
                    'fi-simple-main my-16 w-full bg-white px-6 py-12 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 sm:rounded-xl sm:px-12',
                    match ($maxWidth ??= (filament()->getSimplePageMaxContentWidth() ?? MaxWidth::Large)) {
                        MaxWidth::ExtraSmall, 'xs' => 'max-w-xs',
                        MaxWidth::Small, 'sm' => 'max-w-sm',
                        MaxWidth::Medium, 'md' => 'max-w-md',
                        MaxWidth::Large, 'lg' => 'max-w-lg',
                        MaxWidth::ExtraLarge, 'xl' => 'max-w-xl',
                        MaxWidth::TwoExtraLarge, '2xl' => 'max-w-2xl',
                        MaxWidth::ThreeExtraLarge, '3xl' => 'max-w-3xl',
                        MaxWidth::FourExtraLarge, '4xl' => 'max-w-4xl',
                        MaxWidth::FiveExtraLarge, '5xl' => 'max-w-5xl',
                        MaxWidth::SixExtraLarge, '6xl' => 'max-w-6xl',
                        MaxWidth::SevenExtraLarge, '7xl' => 'max-w-7xl',
                        MaxWidth::Full, 'full' => 'max-w-full',
                        MaxWidth::MinContent, 'min' => 'max-w-min',
                        MaxWidth::MaxContent, 'max' => 'max-w-max',
                        MaxWidth::FitContent, 'fit' => 'max-w-fit',
                        MaxWidth::Prose, 'prose' => 'max-w-prose',
                        MaxWidth::ScreenSmall, 'screen-sm' => 'max-w-screen-sm',
                        MaxWidth::ScreenMedium, 'screen-md' => 'max-w-screen-md',
                        MaxWidth::ScreenLarge, 'screen-lg' => 'max-w-screen-lg',
                        MaxWidth::ScreenExtraLarge, 'screen-xl' => 'max-w-screen-xl',
                        MaxWidth::ScreenTwoExtraLarge, 'screen-2xl' => 'max-w-screen-2xl',
                        default => $maxWidth,
                    },
                ])
            >
                    {{--Slot --}}
                    <div class="flex flex-row justify-center">
                        <img class="w-56 h-56 rounded-full" src="{{ \Filament\Facades\Filament::getUserAvatarUrl(\Filament\Facades\Filament::auth()->user())}}" alt="avatar">
                    </div>     <br>       
                    <div class="flex flex-row justify-center">
               
                        <div class="font-medium dark:text-white">
                            <div>{{\Filament\Facades\Filament::auth()->user()?->name ?? ''}}</div>
                        </div>
                    </div>

                    <x-filament-panels::form wire:submit="authenticate">
                        {{ $this->form }}

                        <x-filament-panels::form.actions
                            :actions="$this->getCachedFormActions()"
                            :full-width="$this->hasFullWidthFormActions()"
                        />
                    </x-filament-panels::form>
                    <div class="text-center">
                        <x-filament::link>
                            <a class="text-primary-600 hover:text-primary-700"
                               href="#!"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('filament-lockscreen::default.button.switch_account') }}</a>
                        </x-filament::link>
                        <form id="logout-form" action="{{ url(filament()->getLogoutUrl()) }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>


                </main>
            </div>
        </div>
    </x-filament-panels::page.simple>
</div>

