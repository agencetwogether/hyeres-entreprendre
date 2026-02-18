<div class="group relative h-[300px] flex-1 overflow-hidden rounded-[10px] sm:h-auto">
    <div class="absolute inset-0 z-[1] bg-gradient-to-b from-transparent to-black"></div>
    <img src="{{ $post->getFirstMediaUrl('featured_image', 'square') }}"
        class="h-full w-full object-cover duration-200 group-hover:scale-110" alt="" />
    @if ($post->category)
        <h5 class="absolute top-5 rounded-sm bg-primary py-1 px-2.5 text-[12px] font-extrabold text-white left-5">
            {{ $post->category->name }}
        </h5>
    @endif
    <div class="absolute bottom-4 left-5 right-5 z-[1] text-white">
        <a href="actualites/{{ $post->slug }}"
            class="text-xl font-black duration-200 hover:text-secondary dark:hover:text-secondary sm:text-[32px] sm:leading-10">
            {{ $post->title }}
        </a>
        <div class="my-3 text-sm font-semibold">
            {{ $post->generateExcerpt }}
        </div>
        <div class="border-b border-white/40"></div>
        <div class="mt-[14px] flex gap-6">
            @if ($post->author)
                <div class="flex items-center gap-3">
                    <img src="{{ $post->author->getFilamentAvatarUrl() }}" class="w-7 rounded-full" alt="" />
                    <p class="text-sm font-semibold">
                        {{ $post->author->getFilamentName() }}
                    </p>
                </div>
            @endif
            <div class="flex items-center gap-2">
                <span>
                    <x-icon class="h-6 w-6 text-white" name="phosphor-calendar-dots" />
                </span>
                <p class="text-sm font-semibold">
                    {{ $post->published_at->format('d/m/Y') }}
                </p>
            </div>
        </div>
    </div>
</div>
