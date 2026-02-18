<section class="bg-secondary-200 py-12 dark:bg-slate-700 md:py-24">
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-center text-3xl font-black text-white sm:text-4xl md:text-[46px] md:leading-[58px]">
            {{ __('app.pages.member-page.our_partners') }}
        </h2>
        <div class="mt-12 grid grid-cols-2 gap-4 md:gap-7 lg:grid-cols-4">
            @foreach ($members as $member)
                <livewire:front.card-member-logo :member="$member" :key="$member->id" />
            @endforeach
        </div>
    </div>
</section>
