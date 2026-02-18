<section class="md:py-20">
    <div class="max-w-6xl mx-auto px-4">
        <h2
            class="mb-12 text-center text-3xl font-black text-primary sm:text-4xl md:text-[46px] md:leading-[58px] capitalize">
            {{ __('app.pages.event.our_events') }}
        </h2>
        <div class="grid gap-5 font-bold text-white sm:grid-cols-2 md:gap-[30px] lg:grid-cols-3">
            @foreach ($events as $event)
                <livewire:front.card-event :event="$event" :key="$event->id" />
            @endforeach
        </div>

        <div class="mt-8 text-center">
            <x-front.btn href="{{ route('events.index') }}" label="{{ __('app.pages.event.show_all') }}"
                type="secondary" />
        </div>
    </div>
</section>
