<x-slot:seo>
    {!! seo($seo ?? null) !!}
</x-slot:seo>
<section>
    <x-front.banner-page
        background-image="{{ getPostSettingsHeader()['banner'] ? getPostSettingsHeader()['banner'] : (array_key_exists('show_default_banner', getPostSettingsHeader()) && getPostSettingsHeader()['show_default_banner'] ? asset('img/test/why-bg.svg') : null) }}"
        :title="getPostSettingsHeader()['title']" :subtitle="getPostSettingsHeader()['description']" />
    <div class="mx-auto max-w-6xl py-32 px-4">
        <div class="flex flex-col items-center gap-5">
            <div class="w-full mt-5 mb-16 flex flex-col flex-wrap gap-16">
                @foreach ($posts as $post)
                    <div
                        class="group grid-cols-2 overflow-hidden rounded-xl bg-secondary-50 dark:bg-gray-dark sm:grid shadow-lg shadow-secondary-100 dark:shadow-secondary-950">
                        <div @class([
                            'overflow-hidden relative',
                            'order-1' => !$loop->even,
                            'order-2' => $loop->even,
                        ])>
                            @if ($post->category)
                                <h5
                                    class="absolute top-5 right-5 rounded-sm bg-secondary py-1 px-2.5 text-sm font-extrabold text-white z-10">
                                    {{ $post->category->name }}
                                </h5>
                            @endif
                            <a href="actualites/{{ $post->slug }}">
                                <img src="{{ $post->getFirstMediaUrl('featured_image', 'webp') }}" alt=""
                                    class="h-full w-full object-cover transition duration-500 group-hover:scale-110" />
                            </a>
                        </div>
                        <div @class([
                            'space-y-4 p-5 font-semibold lg:py-20 lg:px-16',
                            'order-1' => $loop->even,
                            'order-2' => !$loop->even,
                        ])>
                            <h6>{{ __('app.pages.post.published_on', ['date' => $post->published_at->translatedFormat('j F Y')]) }}
                            </h6>
                            <a href="actualites/{{ $post->slug }}"
                                class="text-2xl font-extrabold text-black transition hover:text-secondary dark:text-white dark:hover:text-secondary">
                                {{ $post->title }}
                            </a>
                            <p class="dark:text-gray-300">
                                {{ $post->generateExcerpt }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($posts->hasMorePages())
                <x-front.btn tag="button" wire:click="load" label="{{ __('app.pages.post.show_more') }}"
                    type="secondary" />
            @endif
        </div>
    </div>
</section>
