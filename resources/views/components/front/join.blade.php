<section class="py-32">
    <div class="mx-auto max-w-7xl bg-white py-12 dark:bg-gray-dark sm:rounded-xl lg:py-24 shadow-xl">
        <div class="mx-auto max-w-6xl px-4">
            <div class="text-center w-full">
                <div class="heading mb-8">
                    <h4 class="text-primary!">
                        {{ getSectionJoinTitle() }}
                    </h4>
                </div>
                <div class="mx-auto max-w-4xl mb-8 richeditor-custom text-gray-700 dark:text-gray-300">
                    {{ getSectionJoinContent() }}
                </div>
                <div class="flex justify-center gap-6">
                    @foreach (getSectionJoinLinks() as $link)
                        <x-front.btn href="{{ url($link['url']) }}" label="{{ $link['label'] }}"
                            type="{{ $link['style'] }}" />
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
