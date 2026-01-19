<div>
    @if($visible)
        <x-filament::button
            outlined
            color="danger"
            icon="phosphor-identification-badge"
            labeled-from="sm"
            href="{{ $url }}"
            tag="a"
        >
            {{ __('app.widgets.complete_profil_setup.action.complete') }}
        </x-filament::button>
    @endif
</div>

