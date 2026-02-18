<x-slot:seo>
    {!! seo($seo ?? null) !!}
</x-slot:seo>
<section>
    <x-front.banner-page
        background-image="{{ getLegalSettingsHeader()['banner'] ? getLegalSettingsHeader()['banner'] : (array_key_exists('show_default_banner', getLegalSettingsHeader()) && getLegalSettingsHeader()['show_default_banner'] ? asset('img/test/bg-patent.png') : null) }}"
        :title="getLegalSettingsHeader()['title']" :subtitle="getLegalSettingsHeader()['description']" />
    @if (getLegalSettingsContent()['content'])
        <div class="py-14 md:py-[100px]">
            <div class="mx-auto max-w-6xl px-4 richeditor-custom text-gray-700">
                {{ $this->renderContent() }}
            </div>
        </div>
    @endif
</section>
