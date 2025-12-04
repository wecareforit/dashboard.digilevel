<x-filament::modal>
    {{-- mount the Livewire table --}}
    <livewire:select-elevator-table
        :customer_id="$customer_id"
        wire:key="select-elevator-{{ $customer_id }}"
    />

    {{-- you can also include a hidden input to capture the chosen row --}}
    <input type="hidden" name="selected_object_id" id="selected_object_id" />

    <x-slot name="footer">
        <x-filament::button type="button" wire:click="$emit('closeModal')">Cancel</x-filament::button>
        <x-filament::button form="your-action-form">Confirm</x-filament::button>
    </x-slot>

    <script>
        window.addEventListener('elevator-chosen', event => {
            document.getElementById('selected_object_id').value = event.detail.id;
        });
    </script>
</x-filament::modal>
