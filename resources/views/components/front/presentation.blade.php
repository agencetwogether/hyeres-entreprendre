<section class="py-32 bg-secondary-50 dark:bg-slate-700">
    <div class="mx-auto max-w-7xl bg-white py-12 dark:bg-slate-800 sm:rounded-xl lg:py-24 shadow-xl">
        <div class="mx-auto max-w-6xl px-4">
            <div class="grid lg:grid-cols-2 gap-8">
                <div class="w-full text-center md:text-left">
                    <div class="heading mb-8">
                        <h4 class="text-primary!">
                            {{ getSectionPresentationTitle() }}
                        </h4>
                        <h6 class="mt-[18px] font-semibold! text-gray!">
                            {{ getSectionPresentationSubTitle() }}
                        </h6>
                    </div>
                    <div class="richeditor-custom text-gray-700">
                        {{ getSectionPresentationContent() }}
                    </div>
                </div>
                <div class="grid">
                    @if (count(getSectionPresentationSlider()) > 1)
                        <div class="mb-4 flex justify-end gap-4">
                            <button type="button"
                                class="blog-slider-button-prev flex h-10 w-10 items-center justify-center rounded-full bg-secondary-300 transition hover:bg-secondary dark:hover:bg-secondary hover:text-white">
                                <x-icon class="h-4 w-4" name="phosphor-caret-left-bold" />
                            </button>
                            <button type="button"
                                class="blog-slider-button-next text-p flex h-10 w-10 items-center justify-center rounded-full bg-secondary-300 transition hover:bg-secondary dark:hover:bg-secondary hover:text-white">
                                <x-icon class="h-4 w-4" name="phosphor-caret-right-bold" />
                            </button>
                        </div>
                    @endif
                    <div class="swiper blog-slider w-full">
                        <div class="swiper-wrapper">
                            @foreach (getSectionPresentationSlider() as $image)
                                <div class="swiper-slide">
                                    <img src="{{ url('storage/' . $image) }}"
                                        class="rounded-xl object-cover w-full h-full xl:h-[500px]" alt="" />
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
