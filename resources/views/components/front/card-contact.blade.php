@props([
    'type' => null,
    'icon' => null,
    'text' => null,
    'link' => null,
    'value' => null,
])
@php
    $typeLink = match ($type) {
        'phone' => 'tel:',
        'email' => 'mailto:',
        default => '',
    };
@endphp
<div
    class="flex items-start gap-[10px] rounded-[10px] border border-transparent bg-secondary/10 py-6 px-5 transition hover:border-secondary hover:bg-transparent">
    <span
        class="flex h-[50px] w-[50px] min-w-[50px] items-center justify-center rounded-full bg-secondary-200 text-lg text-white">
        <x-icon class="h-7 w-7 text-secondary" name="{{ $icon }}" />
    </span>
    <div>
        <h6 class="mb-1 font-bold text-secondary">{{ $text }}</h6>
        <{{ $link ? 'a' : 'p' }}
            @if ($link) href
        ="{{ $typeLink }}{{ $value }}" @endif
            class="font-bold text-black transition hover:text-secondary dark:text-white dark:hover:text-secondary
        lg:text-lg">
            {{ $value }}
            </{{ $link ? 'a' : 'p' }}>
    </div>
</div>
