<div class="pt-1 flex rounded-md relative">
    <div class="flex items-center gap-3">
        <div class="h-10 w-10">
            <img src="{{ $image }}" alt="{{ $title }}" role="img" class="h-full w-full rounded-full overflow-hidden shadow object-cover" />
        </div>

        <div class="flex flex-col justify-center">
            <p class="text-sm">{{ $title }}</p>
            <div class="flex flex-col items-start">
                <p class="text-xs leading-5">{{ $description }}</p>
            </div>
        </div>
    </div>
</div>