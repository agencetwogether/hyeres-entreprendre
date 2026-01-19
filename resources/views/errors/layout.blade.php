@php
    use Filament\Support\Facades\FilamentColor;
    use function Filament\Support\get_color_css_variables;
    $level = app()->view->getSections()['level'] ?? 'primary';
    $color = FilamentColor::getColors()[$level];
    $actionReturn = app()->view->getSections()['action_return'];
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ __('filament-panels::layout.direction') ?? 'ltr' }}"
    @class(['fi min-h-screen', 'dark' => filament()->hasDarkModeForced()])>

<head>

    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    @if ($favicon = filament()->getFavicon())
        <link rel="icon" href="{{ $favicon }}" />
    @endif

    <title>
        {{ getAppTitlePrefixPage() }} @yield('title')
    </title>

    @filamentStyles

    {{ filament()->getTheme()->getHtml() }}
    {{ filament()->getFontHtml() }}

    <style>
        :root {
            --font-family: '{!! filament()->getFontFamily() !!}';
            --sidebar-width: {{ filament()->getSidebarWidth() }};
            --collapsed-sidebar-width: {{ filament()->getCollapsedSidebarWidth() }};
            --default-theme-mode: {{ filament()->getDefaultThemeMode()->value }};
        }
    </style>

    @if (!filament()->hasDarkMode())
        <script>
            localStorage.setItem('theme', 'light');
        </script>
    @elseif (filament()->hasDarkModeForced())
        <script>
            localStorage.setItem('theme', 'dark');
        </script>
    @else
        <script>
            const theme = localStorage.getItem('theme') ??
                @js(filament()->getDefaultThemeMode()->value)

            if (
                theme === 'dark' ||
                (theme === 'system' &&
                    window.matchMedia('(prefers-color-scheme: dark)')
                    .matches)
            ) {
                document.documentElement.classList.add('dark');
            }
        </script>
    @endif
</head>

<body
    class="fi-body min-h-screen bg-gray-50 font-normal antialiased dark:bg-gray-950 dark:text-white flex items-center justify-center">

    <section class="mx-auto max-w-screen-xl">
        <div class="mx-auto max-w-screen-sm text-center">
            <h1 class="mb-4 text-7xl tracking-tight font-extrabold lg:text-9xl text-custom-600 dark:text-custom-500"
                @style([
                    get_color_css_variables($color, shades: [600, 500]) => $color !== 'gray',
                ])>
                @yield('code')
            </h1>
            <p class="mb-4 text-3xl tracking-tight font-bold text-gray-950 md:text-4xl dark:text-white">
                @yield('description')
            </p>
            <p class="mb-4 text-lg font-light text-gray-500 dark:text-gray-400">
                @yield('message')
            </p>
            <x-filament::button size="xl" href="{{ $actionReturn }}" tag="a" color="primary">
                {{ __('app.pages.errors.action.return') }}
            </x-filament::button>
        </div>
    </section>
</body>

</html>
