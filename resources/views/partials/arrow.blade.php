@php
    use function Filament\Support\get_color_css_variables;
    $iconColor = 'success';
@endphp
<div class="flex justify-center">
    <x-filament::icon icon="phosphor-caret-double-down"
        class="fi-color-custom text-custom-500 dark:text-custom-400 h-10 w-10 animate-pulse" @style([
            get_color_css_variables($iconColor, shades: [400, 500]) => $iconColor !== 'gray',
        ]) />
</div>
