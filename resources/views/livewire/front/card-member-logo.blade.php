<a href="annuaire/membre/{{ $member->ulid }}">
    <div
        class="rounded-3xl border border-transparent bg-white dark:bg-slate-700 dark:border-slate-800 py-9 px-4 transition-all duration-500 hover:border-primary hover:shadow-xl flex justify-center">
        <img class="object-cover" src="{{ $member->getFirstMediaUrl('company_logo', 'webp') }}"
            alt="{{ $member->company_name }}">
    </div>
</a>
