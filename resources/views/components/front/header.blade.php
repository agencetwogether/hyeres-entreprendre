<header id="top-header" class="sticky top-0 z-50 bg-white dark:bg-slate-800 transition duration-300">
    <div class="max-w-6xl mx-auto px-4">
        <div class="relative flex items-center justify-between py-5 lg:py-0">
            <a href="{{ config('app.url') }}">
                <img class="h-12 lg:h-20 hidden dark:block" src="{{ getClientLogoDark() }}" alt="logo" />
                <img class="h-12 lg:h-20 dark:hidden" src="{{ getClientLogo() }}" alt="logo" />
            </a>
            <div class="flex items-center">
                <div class="overlay fixed inset-0 z-[51] bg-black/60 lg:hidden" :class="[openMenu ? '' : 'hidden']"
                    @click="[ openMenu = !openMenu ]">
                </div>
                <nav class="menus" :class="[openMenu ? 'open-menus' : '']">
                    <div class="border-b border-gray/10 text-right lg:hidden">
                        <button @click="[openMenu = false]" type="button" class="p-4">
                            <x-icon class="h-6 w-6 text-black dark:text-white" name="heroicon-o-x-mark" />
                        </button>
                    </div>
                    <x-filament-menu-builder::menu slug="header" view="partials.menu-list" />
                </nav>
                <ul class="flex items-center gap-5 pr-5 lg:pl-5 lg:pr-0">
                    {{-- <li>
                        <a
                            x-tooltip.raw="{{ __('app.general.go_to_back') }}"
                            href="{{ route('filament.admin.pages.dashboard') }}"
                            class="flex h-10 w-10 items-center justify-center rounded-full bg-secondary text-white hover:bg-secondary-200 hover:text-secondary-800 dark:bg-secondary-800 dark:hover:bg-secondary-800 dark:text-white dark:hover:text-secondary-400 transition duration-300"
                            target="_blank"
                        >
                            <x-icon class="h-6 w-6" name="phosphor-gear" />
                        </a>
                    </li> --}}
                    <li>
                        <button type="button"
                            class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-800 dark:bg-slate-700 text-white hover:text-primary theme-manager-btn">
                            <x-icon class="h-6 w-6 dark:hidden" name="heroicon-o-moon" />
                            <x-icon class="h-6 w-6 hidden dark:block" name="heroicon-o-sun" />
                        </button>
                    </li>
                </ul>
                <button type="button"
                    class="flex h-10 w-10 items-center justify-center rounded-full bg-primary lg:hidden"
                    @click="[ openMenu = !openMenu ]">
                    <x-icon class="h-6 w-6 text-white" name="heroicon-o-bars-4" />
                </button>
            </div>
        </div>
    </div>
</header>
