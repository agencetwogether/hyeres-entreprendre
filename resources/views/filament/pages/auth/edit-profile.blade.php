<x-dynamic-component :component="static::isSimple() ? 'filament-panels::page.simple' : 'filament-panels::page'">
    <x-filament::section icon="phosphor-identification-card" icon-color="success">
        <x-slot name="heading">
            {{ __('app.pages.auth.edit_profile.form.section.information_title') }}
        </x-slot>
        <x-slot name="description">
            {{ __('app.pages.auth.edit_profile.form.section.information_description') }}
        </x-slot>
        <form class="grid gap-y-6" wire:submit="updateProfile">
            {{ $this->editProfileForm }}
            <div>
                {{ $this->getUpdateProfileFormAction() }}
            </div>
        </form>
    </x-filament::section>
    <x-filament::section collapsible collapsed icon="phosphor-lock-key" icon-color="warning">
        <x-slot name="heading">
            {{ __('app.pages.auth.edit_profile.form.section.password_title') }}
        </x-slot>
        <x-slot name="description">
            {{ __('app.pages.auth.edit_profile.form.section.password_description') }}
        </x-slot>
        <form class="grid gap-y-6" wire:submit="updatePassword">
            {{ $this->editPasswordForm }}
            <div>
                {{ $this->getUpdatePasswordFormAction() }}
            </div>
        </form>
    </x-filament::section>
</x-dynamic-component>
