@props([
    'tag' => 'a',
    'href' => '#',
    'label' => null,
    'type' => 'primary',
    'btnType' => 'button',
    'icon' => null,
    'iconPosition' => 'before'
])
<{{ $tag }}
    @if($tag == 'a')
    href="{{ $href }}"
@else
    type="{{ $btnType }}"
@endif
{{ $attributes->class([
    "group inline-flex rounded-2xl py-4 px-7 text-center text-sm font-extrabold uppercase transition duration-300 items-center justify-center gap-4",
    "bg-primary dark:bg-primary-800 text-white hover:bg-primary-400 dark:hover:bg-primary-700 hover:text-white dark:text-white" => $type == 'primary',
    "text-secondary-800 bg-secondary-50 hover:scale-105 hover:bg-secondary hover:text-white dark:bg-secondary-800 dark:text-white dark:hover:bg-secondary-600" => $type == 'secondary',
    "" => $type == 'outlined',
]) }}
>
@if($icon && $iconPosition == 'before')
    <span
            @class([
                "flex h-10 w-10 items-center justify-center rounded-full transition duration-300",
                "bg-primary-200 group-hover:bg-primary-100 dark:group-hover:bg-primary-400" => $type == 'primary',
                "bg-secondary-200 group-hover:bg-secondary-700 dark:group-hover:bg-secondary-400" => $type == 'secondary'
            ])
        >
            <x-icon
                @class([
                    "h-6 w-6 transition duration-300",
                    "text-primary-600 group-hover:text-primary-500" => $type == 'primary',
                    "text-secondary-800 group-hover:text-white" => $type == 'secondary'
                ])
                name="{{ $icon }}"/>
        </span>
@endif
{{ $label }}
@if($icon && $iconPosition == 'after')
    <span
            @class([
                "flex h-10 w-10 items-center justify-center rounded-full transition duration-300",
                "bg-primary-200 group-hover:bg-primary-100 dark:group-hover:bg-primary-400" => $type == 'primary',
                "bg-secondary-200 group-hover:bg-secondary-700 dark:group-hover:bg-secondary-400" => $type == 'secondary'
            ])
        >
            <x-icon
                @class([
                    "h-6 w-6 transition duration-300",
                    "text-primary-600 group-hover:text-primary-500" => $type == 'primary',
                    "text-secondary-800 group-hover:text-white" => $type == 'secondary'
                ])
                name="{{ $icon }}"/>
        </span>
@endif
</{{ $tag }}>
