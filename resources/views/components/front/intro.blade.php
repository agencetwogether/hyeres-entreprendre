<div class="relative bg-black py-28 lg:py-44 xl:py-56">
    @if (getSectionIntroductionBackgroundImage())
        <img src="{{ getSectionIntroductionBackgroundImage() }}" class="absolute inset-0 h-full w-full object-cover" />
    @endif
    <div class="absolute inset-0 z-[1] bg-linear-to-b from-black/50 to-black/40"></div>
    <div class="max-w-6xl mx-auto px-4 relative z-[1]">
        <div class="max-w-[400px] space-y-5 text-white lg:max-w-[560px]">
            <p class="text-xl">{{ getSectionIntroductionSubTitle() }}</p>
            <div class="text-4xl font-extrabold uppercase lg:text-6xl richeditor-custom">
                <p>{{ getSectionIntroductionTitle() }}</p>
            </div>
            <div class="font-semibold lg:text-lg richeditor-custom">
                {{ getSectionIntroductionContent() }}
            </div>
            @if (getSectionIntroductionLink()['is_visible'])
                <x-front.btn href="{{ url(getSectionIntroductionLink()['url']) }}" label="{!! getSectionIntroductionLink()['label'] !!}"
                    type="primary" />
            @endif
        </div>
    </div>
</div>
