<x-filament-panels::page>
    <x-filament::section icon="phosphor-lock-key" icon-color="danger">
        <x-slot name="heading">
            {{ __('app.pages.auth.change-password.form.section.password_title') }}
        </x-slot>
        <x-slot name="description">
            {{ __('app.pages.auth.change-password.form.section.password_description') }}
        </x-slot>
        <x-filament-panels::form wire:submit="updatePassword">
            {{ $this->editPasswordForm }}
            <x-filament-panels::form.actions :actions="$this->getUpdatePasswordFormActions()" />
        </x-filament-panels::form>
    </x-filament::section>
</x-filament-panels::page>
