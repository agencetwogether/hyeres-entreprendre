<x-simple-layout
    title="{!! getFormMemberPublicSettingsContent()['title'] !!}"
>
    <x-slot:seo>
        {!! seo($seo ?? null) !!}
    </x-slot>
    @livewire('create-front-member', ['invitation' => $invitation])
</x-simple-layout>



