<div class="mt-20 mb-10">
    <x-filament::section>
        <h4 class="text-primary">
            {{ getFormMemberPublicSettingsContent()['thanks']['title'] }}
        </h4>
        <div class="richeditor-custom max-w-none">
            {{ $textFormSubmittedContent }}
        </div>
        <x-filament::button tag="a" :href="getClientWebsite()" class="my-4">
            {{ __('app.pages.front-register-member.back_button_label') }}
        </x-filament::button>
    </x-filament::section>
</div>
