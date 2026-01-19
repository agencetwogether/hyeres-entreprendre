<div class="flex flex-row gap-4 items-center">
    {{ __('app.pages.edit-permission.form.placeholder.assigned_roles') }}
    @foreach($user->getRoleNames() as $role)
        <x-filament::badge>
            {{ $role }}
        </x-filament::badge>
    @endforeach</div>

