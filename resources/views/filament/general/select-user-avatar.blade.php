<div class="flex rounded-md relative">
    <div class="flex">
        <div class="px-2 py-2">
            <x-filament::avatar
                src="{{ url($avatar) }}"
                alt="{{ $title }}"
                size="lg"
            />
        </div>
        <div class="flex flex-col justify-center pl-3 py-2">
            <p class="text-sm font-bold pb-1">{{ $title }}</p>
            <div class="flex flex-col items-start">
                <p class="text-xs leading-5">{{ $description }}</p>
            </div>
        </div>
    </div>
</div>
