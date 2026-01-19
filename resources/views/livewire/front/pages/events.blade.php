<x-slot:seo>
    {!! seo($seo ?? null) !!}
</x-slot>
<section>
    <x-front.banner-page
        background-image="{{ getEventSettingsHeader()['banner'] ? getEventSettingsHeader()['banner'] : (array_key_exists('show_default_banner', getEventSettingsHeader()) && getEventSettingsHeader()['show_default_banner'] ? asset('img/test/bg-patent.png') : null) }}"
        :title="getEventSettingsHeader()['title']" :subtitle="getEventSettingsHeader()['description']" />
    <div class="mx-auto max-w-6xl py-32 px-4">
        <div class="flex flex-col items-center gap-5">
            <div class="w-full mt-5 flex flex-col flex-wrap">
                @foreach ($events as $event)
                    <div
                        class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-10 group bg-secondary-50 dark:bg-gray-dark rounded-xl shadow-lg shadow-secondary-100 dark:shadow-secondary-950 ">
                        <div class="p-4 place-content-center justify-self-center">
                            <h3
                                class="text-2xl text-center font-bold mb-5 text-secondary-800 dark:text-white line-clamp-2">
                                <a class="transition-all" href="evenements/{{ $event->slug }}">
                                    {{ $event->title }}
                                </a>
                            </h3>
                        </div>
                        <div class="p-4 place-content-center justify-self-center">
                            <img class="w-full rounded-xl object-cover transition duration-500 group-hover:scale-110 aspect-16/9"
                                src="{{ $event->getFirstMediaUrl('banner', 'webp') }}" alt="">
                        </div>
                        <div class="place-content-center p-4">
                            <ul class="flex flex-col gap-3">
                                <li class="flex flex-wrap gap-4 items-center">
                                    <x-icon class="h-6 w-6 dark:text-white" name="phosphor-calendar-dots" />
                                    <div class="text-sm">
                                        <p>{{ $event->date_start->format('d/m/Y') }}</p>
                                    </div>
                                </li>
                                @if (filled($event->date_end))
                                    <li class="flex flex-wrap gap-4 items-center">
                                        <x-icon class="h-6 w-6 dark:text-white" name="phosphor-clock-countdown" />
                                        <div class="text-sm">
                                            <p>{{ getDuration($event->date_start, $event->date_end) }}</p>
                                        </div>
                                    </li>
                                @endif
                                <li class="flex flex-wrap gap-4 items-center">
                                    <x-icon class="h-6 w-6 dark:text-white" name="phosphor-map-pin" />
                                    <div class="text-sm">
                                        <p>{{ $event->location }}</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="p-4 place-content-center justify-self-center">
                            <x-front.btn href="evenements/{{ $event->slug }}"
                                label="{{ __('app.pages.event.more_details') }}" type="primary" />
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($events->hasMorePages())
                <x-front.btn tag="button" wire:click="load" label="{{ __('app.pages.event.show_more') }}"
                    type="secondary" />
            @endif
        </div>
    </div>

</section>
