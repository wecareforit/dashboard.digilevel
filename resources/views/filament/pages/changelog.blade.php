<x-filament-panels::page>
    {{-- Page Header --}}
    <div class="fi-page-header flex flex-col gap-4 pb-6">
        <div class="flex flex-col gap-2">
            <h1 class="fi-page-header-heading text-2xl font-bold tracking-tight text-gray-950 dark:text-white sm:text-3xl">
                {{ $this->getHeading() }}
            </h1>
            <p class="fi-page-header-description max-w-2xl text-sm text-gray-600 dark:text-gray-400">
                {{ __('Recent updates and improvements to the application') }}
            </p>
        </div>
    </div>

    {{-- Changelog Content --}}
    <div class="fi-page-content-holder">
        <div class="fi-page-content grid gap-6">
            @foreach($changelogEntries as $entry)
                <div class="fi-card relative overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                    <div class="p-6">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <h3 class="text-lg font-semibold leading-6 text-gray-900 dark:text-white">
                                {{ $entry['version'] }}
                            </h3>
                            <span class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400">
                                <x-filament::icon
                                    alias="changelog::date"
                                    icon="heroicon-o-calendar"
                                    class="h-4 w-4"
                                />
                                {{ \Carbon\Carbon::parse($entry['date'])->translatedFormat('j F Y') }}
                            </span>
                        </div>

                        <ul class="mt-4 space-y-2.5 pl-5 text-gray-600 dark:text-gray-300">
                            @foreach($entry['changes'] as $change)
                                <li class="relative pl-2 before:absolute before:left-0 before:top-2 before:h-1.5 before:w-1.5 before:rounded-full before:bg-gray-400 dark:before:bg-gray-500">
                                    {{ $change }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-filament-panels::page>