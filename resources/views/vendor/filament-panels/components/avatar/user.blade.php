@props([
    'user' => filament()->auth()->user(),
])

<x-filament::avatar
    :src="filament()->getUserAvatarUrl($user)"
            class="w-8 h-8 rounded-full border border-gray-300"
    :alt="__('filament-panels::layout.avatar.alt', ['name' => filament()->getUserName($user)])"
    :attributes="
        \Filament\Support\prepare_inherited_attributes($attributes)
            ->class(['fi-user-avatar'])
    "
/>
