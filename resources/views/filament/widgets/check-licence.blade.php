@php use function Filament\Support\get_color_css_variables; @endphp
<x-filament-widgets::widget>
    <x-filament::section @class([
        'fi-color-custom ring-custom-500! dark:ring-custom-400!' => !$isValid,
    ]) @style([
        get_color_css_variables($color, shades: [400, 500]) => !$isValid,
    ])>
        <div class="flex items-center gap-x-3">

            <div class="flex-1">
                <h2 class="grid flex-1 text-base font-semibold leading-6 text-gray-950 dark:text-white">
                    {{ getLicenceName() }}
                </h2>

                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ $description }} <span @class([
                        'font-bold fi-color-custom text-custom-500 dark:text-custom-400',
                    ])
                        @style([get_color_css_variables($color, shades: [400, 500])])>{{ getLicenceEndsAt()->translatedFormat('j F Y') }}</span>
                </p>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
