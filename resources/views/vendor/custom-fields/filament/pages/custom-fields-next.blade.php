<x-filament-panels::page>
    <x-filament::tabs label="Content tabs" contained>
        @foreach ($this->entityTypes as $key => $label)
            <x-filament::tabs.item active="{{ $key === $this->currentEntityType }}"
                                   wire:click="setCurrentEntityType('{{ addslashes($key) }}')">
                {{ $label }}
            </x-filament::tabs.item>
        @endforeach
    </x-filament::tabs>

    <div class="custom-fields-component">
        <div
            x-sortable
            wire:end.stop="updateSectionsOrder($event.target.sortable.toArray())"
            class="flex flex-col gap-y-6"
            x-load-css="[@js(\Filament\Support\Facades\FilamentAsset::getStyleHref('custom-fields', 'relaticle/custom-fields'))]"
        >
            @foreach ($this->sections as $section)
                @livewire('manage-custom-field-section', ['entityType' => $this->currentEntityType, 'section' => $section], key($section->id . str()->random(16)))
            @endforeach

            @if(!count($this->sections))
                <x-filament::grid.column default="12">
                <x-filament::section>
<center>
  <img class="w-40 h-40" src="/images/emptysmallpng.png" alt="">
  <h3 class="mt-2 text-sm font-semibold text-gray-900">Geen gegevens gevonden</h3>
  <p class="mt-1 text-sm text-gray-500">Voeg nieuwe gegevens toe of pas de zoek / selectie filters aan</p>
  </center>



</x-filament::section>



                </x-filament::grid.column>
            @endempty
<div style = "height: 300px;">
            {{ $this->createSectionAction }}
</div>
        </div>
    </div>
</x-filament-panels::page>
