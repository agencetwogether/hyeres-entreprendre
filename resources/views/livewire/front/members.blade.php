@php use Illuminate\Support\HtmlString; @endphp
<section class="bg-gradient-to-t from-white/[55%] to-transparent py-14 dark:from-white/5 md:py-20">
    <div class="max-w-6xl mx-auto px-4">
        <div class="heading-gradiant xl:w-1/2">
            <h4>{{ new HtmlString(__('app.pages.member-page.directory_title')) }}</h4>
        </div>
        <div class="grid gap-5 font-bold text-white sm:grid-cols-2 md:gap-[30px] lg:grid-cols-3">
            @foreach ($members as $member)
                <livewire:front.card-member :member="$member" :key="$member->id">
            @endforeach
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('members') }}"
                class="btn bg-[#00111f0f] dark:bg-white/5 dark:text-white dark:hover:bg-secondary">{{ __('app.pages.member-page.see_all_members') }}</a>
        </div>
    </div>
</section>
