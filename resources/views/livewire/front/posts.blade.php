<section class="py-12 lg:py-24">
    @php
        $count = count($posts);
    @endphp
    <div class="max-w-6xl mx-auto px-4">
        <h2
            class="mb-12 text-center text-3xl font-black text-primary sm:text-4xl md:text-[46px] md:leading-[58px] capitalize">
            {{ __('app.pages.post.our_posts') }}
        </h2>
        <div class="mt-5 grid grid-cols-1 gap-5 lg:grid-cols-2" data-aos="flip-left" data-aos-duration="1000">
            <livewire:front.card-post-featured :post="$featuredPost" :key="$featuredPost->id" />

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                @foreach ($posts as $post)
                    <livewire:front.card-post :post="$post" :key="$post->id" />
                @endforeach
            </div>

        </div>
        <div class="mt-8 text-center">
            <x-front.btn href="{{ route('posts.index') }}" label="{{ __('app.pages.post.see_all_posts') }}"
                type="secondary" />
        </div>
    </div>
</section>
