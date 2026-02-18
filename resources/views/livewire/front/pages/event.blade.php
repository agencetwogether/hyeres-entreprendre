<x-slot:seo>
    {!! seo($seo ?? null) !!}
</x-slot:seo>
<section>
    <x-front.banner-page backgroundImage="{{ $event->getFirstMediaUrl('banner', 'webp') }}" />
    <div class="md:-mt-14 lg:-mt-24 md:mb-8">
        <div class="max-w-4xl mx-auto px-4">
            <div class="relative z-[1]">
                <div class="md:rounded-xl bg-white md:shadow-lg p-4 dark:bg-slate-700 lg:p-10">
                    <h1
                        class="mb-6 text-center text-3xl md:text-2xl font-extrabold text-secondary dark:text-white lg:text-[40px] lg:leading-[50px]!">
                        {{ $event->title }}
                    </h1>
                    <div
                        class="flex flex-col gap-6 md:text-lg font-semibold sm:flex-row justify-center dark:text-secondary-200">
                        <div class="flex items-center gap-2">
                            <x-icon class="h-6 w-6 md:h-8 md:w-8 text-secondary dark:text-secondary-400"
                                name="phosphor-calendar-dots" />
                            <span>
                                {{ $event->date_start->format('d/m/Y') }}
                            </span>
                        </div>

                        <div class="flex items-center gap-2">
                            <x-icon class="h-6 w-6 md:h-8 md:w-8 text-secondary dark:text-secondary-400"
                                name="phosphor-clock" />
                            <span>
                                {{ $event->date_start->format('H:i') }}
                            </span>
                        </div>

                        @if ($event->date_end)
                            <div class="flex items-center gap-2">
                                <x-icon class="h-6 w-6 md:h-8 md:w-8 text-secondary dark:text-secondary-400"
                                    name="phosphor-clock-countdown" />
                                <span>
                                    {{ getDuration($event->date_start, $event->date_end) }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mx-auto max-w-6xl px-4 py-20">
        <div class="richeditor-custom text-gray-700 dark:text-gray-300 max-w-full">
            {{ $this->renderContent() }}
        </div>

        @if (filled($event->external_link) && $event->external_link['link_is_visible'])
            <x-front.btn class="my-8" href="{{ url($event->external_link['link_url']) }}"
                label="{{ $event->external_link['link_label'] }}" type="secondary" target="_blank" />
        @endif
        <x-front.social-share />
    </div>

</section>
