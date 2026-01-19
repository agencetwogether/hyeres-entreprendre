<footer
    class="fixed bottom-0 z-20 w-full p-1 bg-white border-t border-gray-950/5 shadow md:flex md:items-center md:justify-between md:p-2 dark:bg-gray-900 dark:border-white/10">
    <span class="text-xs text-gray-500 sm:text-center dark:text-gray-400">© {{ now()->format('Y') }} -
        {{ getAppDedicated() }} -
        @livewire('agencetwogether.filament.terms-conditions.action.link.terms')
    </span>
</footer>
