<x-simple-layout title="{!! getFormMemberPublicSettingsContent()['title'] !!}">
    <x-slot:seo>
        {!! seo($seo ?? null) !!}
    </x-slot:seo>
    @livewire('create-front-member', ['invitation' => $invitation])
</x-simple-layout>
