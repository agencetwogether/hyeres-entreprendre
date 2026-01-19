<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
<head>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon.png') }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{ $seo ?? null }}
    @livewireStyles
    @filamentStyles
    @cookieconsentscripts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('scripts')
</head>

<body
    style="display: none;"
    x-data="{ openMenu: false }"
    class="scroll-smooth antialiased dark:bg-slate-800"
    :class="[openMenu ? 'overflow-hidden' : 'overflow-visible']"
>

<div
    class="flex min-h-screen flex-col bg-white font-sans text-base font-normal text-gray dark:bg-slate-800"
>
    <x-front.header/>
    <div class="-mt-[82px] flex-grow overflow-x-hidden lg:-mt-[106px]">
        {{ $slot }}
    </div>
    <x-front.footer/>

</div>
@cookieconsentview
@livewireScripts
@filamentScripts
</body>
</html>
