<x-slot:seo>
    {!! seo($seo ?? null) !!}
</x-slot>

<div>
    @if(getSectionIntroductionIsVisible())
        <x-front.intro/>
    @endif
    @if(getSectionPresentationIsVisible())
        <x-front.presentation/>
    @endif
    @if(getSectionJoinIsVisible())
        <x-front.join/>
    @endif
    <livewire:front.partners-logo/>
    <livewire:front.members-logo/>
    <livewire:front.events/>
    <livewire:front.posts/>
</div>
