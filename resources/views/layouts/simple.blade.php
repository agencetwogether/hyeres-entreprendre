@props([
    'logo' => getClientLogo(),
    'title' => config('app.name'),
])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">

<head>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon.png') }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{ $seo ?? null }}
    @filamentStyles
    @cookieconsentscripts
    @vite('resources/css/app.css')
</head>

<body class="antialiased bg-gray-100">
    <div class="max-w-7xl mx-auto mb-10">
        <header class="pt-12">
            @if ($logo)
                <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                    <img class="mx-auto h-20 w-auto" src="{{ $logo }}" alt="{{ getClientName() }}">
                </div>
            @endif
            <div class="sm:mx-auto sm:w-full sm:max-w-7xl">
                <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight">{{ $title }}</h2>
            </div>
        </header>
        {{ $slot }}
    </div>
    @cookieconsentview
    @filamentScripts
    @vite('resources/js/app.js')
    @livewire('notifications')
</body>

</html>
