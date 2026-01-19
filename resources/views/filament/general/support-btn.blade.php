@php use App\Filament\Pages\Support; @endphp
<div class="relative flex">
    <x-filament::icon-button icon="phosphor-lifebuoy" color="success" size="lg" :href="Support::getUrl()" tag="a"
        tooltip="{{ __('app.pages.support.action.label.support') }}"
        label="{{ __('app.pages.support.action.label.support') }}" />
</div>
