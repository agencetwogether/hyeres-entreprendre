<div class="grid gap-5 font-bold text-white sm:grid-cols-2 md:gap-[30px] lg:grid-cols-4">
    @foreach ($members as $member)
        <livewire:front.card-member :member="$member" :key="$member->id"/>
    @endforeach
</div>
