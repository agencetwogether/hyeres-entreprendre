@props([
    'backgroundImage' => null,
    'title' => null,
    'subtitle' => null,
])
<div style="{{ $backgroundImage ? "background-image: url('" . $backgroundImage . "');" : '' }}"
    @class([
        'relative pt-[82px] lg:pt-[106px]',
        'bg-cover bg-center bg-no-repeat' => $backgroundImage,
        'bg-secondary-800 dark:bg-secondary-950' => filled($backgroundImage),
    ])>
    <div class="absolute inset-0 bg-black/30 dark:bg-black/60"></div>
    <div class="mx-auto max-w-6xl px-4">
        <div class="items-center justify-between py-10 md:flex md:h-[400px] md:py-0">
            <div class="heading relative mb-0 text-center md:text-left">
                @if ($title)
                    <h4 class="text-white! capitalize">
                        {{ $title }}
                    </h4>
                @endif
                @if ($subtitle)
                    <h6>{{ $subtitle }}</h6>
                @endif
            </div>
        </div>
    </div>
</div>
