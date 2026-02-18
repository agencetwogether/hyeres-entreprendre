<div class="flex flex-row items-center gap-2 text-xl">
    @if (getClientLogo())
        <img class="h-10 dark:hidden" src="{{ getClientLogoDark() }}" alt="logo" />
        <img class="h-10 hidden dark:block" src="{{ getClientLogo() }}" alt="logo" />
    @endif
</div>
