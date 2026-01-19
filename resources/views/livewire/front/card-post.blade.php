<div class="group relative h-[263px] w-full overflow-hidden rounded-[10px] lg:max-w-[263px]">
    <div class="absolute inset-0 z-[1] bg-gradient-to-b from-transparent to-black"></div>
    <img src="{{ $post->getFirstMediaUrl('featured_image', 'square') }}"
        class="h-full w-full rotate-0 object-cover duration-200 group-hover:scale-110" alt="" />
    @if ($post->category)
        <h5 class="absolute top-5 rounded-sm bg-secondary py-1 px-2.5 text-[12px] font-extrabold text-white right-5">
            {{ $post->category->name }}
        </h5>
    @endif
    <div class="absolute bottom-4 left-5 right-5 z-[1] text-white">
        <a href="actualites/{{ $post->slug }}"
            class="text-[19px] font-bold duration-200 hover:text-secondary dark:hover:text-secondary">
            {{ $post->title }}
        </a>
        <div class="mt-[14px] flex items-center gap-2">
            <span>
                <x-icon class="h-6 w-6 text-white" name="phosphor-calendar-dots" />
            </span>
            <p class="text-sm font-semibold">
                {{ $post->published_at->format('d/m/Y') }}
            </p>
        </div>
    </div>
</div>
