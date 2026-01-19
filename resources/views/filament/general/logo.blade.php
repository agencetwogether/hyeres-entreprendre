<div class="flex flex-row items-center gap-2 text-xl">
    @if(getClientLogo())
        <img class="h-10 light-mode-btn hidden" src="{{ getClientLogoDark() }}" alt="logo"/>
        <img class="h-10 dark-mode-btn" src="{{ getClientLogo() }}" alt="logo"/>
    @endif
</div>
