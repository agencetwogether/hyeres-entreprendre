@php
    use Illuminate\Support\Arr;

    $bgStyles = Arr::toCssStyles([
        Filament\Support\get_color_css_variables($this->getBgColor(), shades: [50, 400]) =>
            $this->getBgColor() !== 'gray',
    ]);

    $textStyles = Arr::toCssStyles([
        Filament\Support\get_color_css_variables($this->getColor(), shades: [400, 500]) => $this->getColor() !== 'gray',
    ]);

@endphp
<x-filament-widgets::widget>
    <x-filament::section @class([
        'bg-white' => blank($this->getBgColor()),
        'bg-custom-50 dark:bg-custom-400/10' => filled($this->getBgColor()),
    ]) style="{{ $bgStyles }}">
        <div class="flex flex-col items-center justify-center">
            <h1 class="text-lg font-semibold text-custom-400 dark:text-custom-500" style="{{ $textStyles }}">
                {{ $this->getTitle() }}</h1>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
