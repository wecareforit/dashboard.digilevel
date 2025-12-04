<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">



@if($getRecord()?->GpsDataLatestLocation?->imei)
    <iframe width="100%" height="200" src="https://maps.google.com/maps?q={{$getRecord()->GpsDataLatestLocation->lat}}, {{$getRecord()->GpsDataLatestLocation->lng}}&output=embed"></iframe>
        @else
        <div class="flex flex-col items-center justify-center p-6 text-gray-500" >
            <x-filament::icon
                icon="heroicon-o-map"
                wire:target="search"
                class="w-10 h-10 text-gray-400"
            />
            <h3 class="mt-2 text-lg font-semibold text-gray-700">Geen locatiegegevens</h3>
            <p class="mt-1 text-sm text-gray-500 text-center">
                Er zijn momenteel geen live locatiegegevens beschikbaar.
            </p>
        </div>
    @endif
</x-dynamic-component>
