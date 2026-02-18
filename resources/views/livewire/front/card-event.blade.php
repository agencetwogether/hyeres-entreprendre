<div class="relative h-[400px] overflow-hidden rounded-lg bg-secondary">
    <a href="evenements/{{ $event->slug }}" class="group">
        <img src="{{ $event->getFirstMediaUrl('banner', 'square') }}" alt=""
            class="h-full w-full object-cover transition duration-500 group-hover:scale-125" />
    </a>
    <div class="absolute top-4 flex items-center gap-1.5 rounded-full bg-white py-2.5 px-5 right-4">
        <x-icon class="h-6 w-6 text-primary" name="heroicon-o-calendar" />
        <span class="text-gray text-sm">{{ $event->date_start->format('d/m/Y') }}</span>
    </div>
    <div class="absolute inset-x-0 bottom-0 w-full">
        <div class="bg-gray-400 dark:bg-gray-500 p-4 backdrop-blur-3xl">
            <div class="mb-4 flex items-center justify-between gap-4">
                <a href="evenements/{{ $event->slug }}">
                    <h5>{{ $event->title }}</h5>
                </a>
            </div>
            <div class="flex items-center justify-between gap-4">
                <div class="flex items-center gap-2.5">
                    <div class="h-8 w-8 overflow-hidden rounded-full">
                        <x-icon class="h-full w-full text-white" name="heroicon-o-map-pin" />
                    </div>
                    <div>
                        <p class="text-sm">{{ $event->location }}</p>
                        @if ($event->date_end && $event->date_end->greaterThan($event->date_start))
                            <span
                                class="text-xs opacity-90">{{ getDuration($event->date_start, $event->date_end) }}</span>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
