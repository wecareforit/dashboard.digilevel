@php
    $state = $getState();
    $image = $getImage();
    $record = $getRecord();
    $description = $getDescription();
    $tooltip = $getTooltip();
    $hasTooltip = filled($tooltip);
    $hasPopover = filled($popover);
    $popover = $getPopover();
    $icon = $getIcon($state);
@endphp

@capture($tile)
    <div
         @if ($hasTooltip)
             x-tooltip="{
                content: @js($tooltip),
                theme: $store.theme,
            }"
         @endif
         @class([
            'w-full',
            'grid gap-y-1' => !isset($field),
        ])
>
    <div class="flex items-center justify-between" @click="$refs.panel.toggle">
        <div class="inline-flex items-center gap-2">
            @if(filled($image))
                <img
                    alt="{{ $state }}"
                    class="h-8 w-8 text-gray-400 dark:text-gray-500"
                    src="{{ $image }}"
                >
            @endif

            <div>
                <span class="text-sm leading-6 text-gray-950 dark:text-white">
                    {{ $state }}
                </span>
                @if (filled($description))
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $description }}
                    </p>
                @endif
            </div>
        </div>

        @if(filled($icon))
            <x-filament::icon
                    :icon="$icon"
                    class="h-4 w-4 text-gray-500 dark:text-gray-400"
            />
        @endif
    </div>

    @if($hasPopover)
        <div class="z-50 transition"
             x-transition:enter-start="opacity-0"
             x-transition:leave-end="opacity-0"
             x-cloak
             x-ref="panel"
             x-float.placement.bottom.flip.teleport
        >
            {!! $popover !!}
        </div>
    @endif

</div>
@endcapture

@if(isset($field))
    <x-dynamic-component
        :component="$getFieldWrapperView()"
        :field="$field"
    >
        {{ $tile() }}
    </x-dynamic-component>
@else
    {{ $tile() }}
@endif
