<div class="mt-2 flex flex-col gap-2">
    <div class="flex flex-row gap-2 items-center">
        <span class="flex flex-row gap-2 items-center">
            {{ __('app.pages.manage-licence.form.placeholder.from') }} <x-filament::badge color="success">
                {{ getLicenceStartsAt()->translatedFormat('l d/m/Y') }}
            </x-filament::badge>
        </span>
        <span class="flex flex-row gap-2 items-center">
            {{ __('app.pages.manage-licence.form.placeholder.to') }} <x-filament::badge color="danger">
                {{ getLicenceEndsAt()->translatedFormat('l d/m/Y') }}
            </x-filament::badge>
        </span>
    </div>
    <p>{{ __('app.pages.manage-licence.form.label.price') }} : {{ getLicencePrice() }}€</p>
    <p>{{ __('app.pages.manage-licence.form.label.duration_subscribe_licence') }} : {{ getLicenceFormatDuration() }}</p>
</div>
