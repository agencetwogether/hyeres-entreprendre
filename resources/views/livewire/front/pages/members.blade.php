<x-slot:seo>
    {!! seo($seo ?? null) !!}
</x-slot>
<!-- background-image="{{ asset('img/test/bg-patent.png') }}" -->
<section>
    <x-front.banner-page
        background-image="{{ getDirectorySettingsHeader()['banner'] ? getDirectorySettingsHeader()['banner'] : (array_key_exists('show_default_banner', getDirectorySettingsHeader()) && getDirectorySettingsHeader()['show_default_banner'] ? asset('img/test/bg-patent.png') : null) }}"
        :title="getDirectorySettingsHeader()['title']"
        :subtitle="getDirectorySettingsHeader()['description']"
    />
    <div class="mx-auto max-w-6xl py-32 px-4">
        @livewire('front.member-list')
    </div>
</section>
