<x-slot:seo>
    {!! seo($seo ?? null) !!}
</x-slot>
<section>
    <x-front.banner-page backgroundImage="{{ $post->getFirstMediaUrl('featured_image', 'webp') }}" />
    <div class="md:-mt-14 lg:-mt-24 md:mb-8">
        <div class="max-w-4xl mx-auto px-4">
            <div class="relative z-[1]">
                <div class="md:rounded-xl bg-white md:shadow-lg p-4 dark:bg-slate-700 lg:p-10">
                    <h1
                        class="mb-6 text-center text-3xl md:text-2xl font-extrabold text-primary dark:text-white lg:text-[40px] lg:leading-[50px]!">
                        {{ $post->title }}
                    </h1>
                    <div
                        class="flex flex-col gap-6 md:text-lg font-semibold sm:flex-row justify-center dark:text-secondary-200">
                        @if ($post->author)
                            <div class="flex items-center gap-2">
                                <img class="h-6 w-6 md:h-8 md:w-8 rounded-full"
                                    src="{{ $post->author->getFilamentAvatarUrl() }}" alt="avtar" />
                                <span>{{ $post->author->getFilamentName() }}</span>
                            </div>
                        @endif
                        @if ($post->category)
                            <div class="flex items-center gap-2">
                                <x-icon class="h-6 w-6 md:h-8 md:w-8 text-secondary dark:text-secondary-400"
                                    name="phosphor-tag" />
                                <span>
                                    {{ $post->category->name }}
                                </span>
                            </div>
                        @endif
                        <div class="flex items-center gap-2">
                            <x-icon class="h-6 w-6 md:h-8 md:w-8 text-secondary dark:text-secondary-400"
                                name="phosphor-calendar-dots" />
                            <span>
                                {{ __('app.pages.post.published_on', ['date' => $post->published_at->translatedFormat('j F Y')]) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mx-auto max-w-6xl px-4 py-20">
        <div class="richeditor-custom text-gray-700 max-w-full">
            {{ $this->renderContent() }}
        </div>
        <x-front.social-share />
    </div>

</section>
