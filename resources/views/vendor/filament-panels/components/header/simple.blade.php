@props([
    'heading' => null,
    'logo' => true,
    'subheading' => null,
])


@php
    $tenantInfo = Cache::get('tenant');
	$tenantData = json_decode($tenantInfo->data);
@endphp



<header class="fi-simple-header flex flex-col items-center pb-10">


 
    @if ($tenantData?->logo)
        <img 
            src="{{ $tenantData?->logo}}" 
            alt="{{ $tenantData?->name}}" 
            style = "max-height: 150px;"
            class="  mb-4"
        >
        @else

    @endif

    @if (filled($heading))
        <h1 class="fi-simple-header-heading text-center text-2xl font-bold tracking-tight text-gray-950 dark:text-white">
            {{ $heading }}
        </h1>
    @endif

    @if (filled($subheading))
        <p class="fi-simple-header-subheading mt-2 text-center text-sm text-gray-500 dark:text-gray-400">
            {{ $subheading }}
        </p>
    @endif
</header>
