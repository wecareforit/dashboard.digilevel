@props([
    'icon' => 'heroicon-o-clipboard-document-list',
    'title' => 'Geen gegevens gevonden',
    'description' => 'Er zijn nog geen items beschikbaar.',
    'action' => null,
])

<div class="flex flex-col items-center justify-center py-16 text-center text-gray-600 empty-state">
    <x-dynamic-component :component="$icon" class="w-16 h-16 text-gray-400 mb-4" />

    <h2 class="text-xl font-semibold mb-2">
        {{ $title }}
    </h2>

    <p class="mb-6">
        {{ $description }}
    </p>

    @if ($action)
        {{ $action }}
    @endif
</div>