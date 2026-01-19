@php
    use App\Enums\SocialNetwork;
@endphp
<footer class="mt-auto bg-secondary-100 dark:bg-slate-700">
    <div class="max-w-6xl mx-auto px-4">
        <div class="grid gap-y-10 gap-x-4 py-14 sm:grid-cols-3 lg:grid-cols-5 lg:py-[100px]">
            <div class="relative col-span-2">
                <img src="{{ getClientLogoDark() }}" alt="plurk" class="w-3/4 light-mode-btn hidden" />
                <img src="{{ getClientLogo() }}" alt="plurk" class="w-1/2 md:w-2/3 dark-mode-btn" />
                @if (!empty(getSocialsNetworks()))
                    <ul class="mt-12 flex items-center gap-8">
                        @foreach (getSocialsNetworks() as $item)
                            <li class="z-50">
                                <a target="_blank" href="{{ url($item['account']) }}">
                                    <x-icon class="h-8 w-8 transition hover:scale-110"
                                        style="color: {{ SocialNetwork::from($item['name'])->getHexColor() }};"
                                        :name="SocialNetwork::from($item['name'])->getIcon()" />
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
                <img src="{{ asset('storage/footer-patern.png') }}" alt="footer-shape"
                    class="absolute bottom-0 right-0 sm:left-0" />
                <img src="{{ asset('storage/footer-patern-dark.png') }}" alt="footer-shape-dark"
                    class="absolute bottom-0 right-0 hidden dark:block sm:left-0" />
            </div>
            <div class="col-span-2">
                <p class="mb-6 text-lg font-extrabold text-secondary dark:text-white">Accès rapides</p>
                <x-filament-menu-builder::menu slug="footer" view="partials.menu-list-footer" />
            </div>
            <div>
                <ul class="flex flex-col gap-3 font-bold">
                    <li class="mb-3 text-lg font-extrabold text-secondary dark:text-white">Information</li>
                    <li>{{ getClientAddress() }}, {{ getClientPostalCode() }} {{ getClientCity() }}</li>
                    <li>
                        <a href="tel:{{ getClientPhone() }}"
                            class="inline-block transition hover:scale-110 hover:text-secondary">{{ phone(getClientPhone())->formatNational() }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="bg-secondary-50 py-5 dark:bg-slate-800">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex flex-col items-center justify-between text-center font-bold dark:text-white md:flex-row">
                <div>
                    Copyright© {{ now()->year }}
                    <a href="{{ config('app.url') }}"
                        class="text-primary transition hover:text-secondary">{{ getClientName() }}</a>
                </div>
                <div>{{ __('app.general.application_created') }} <a href="{{ getGeneratorWebsite() }}"
                        class="text-secondary transition hover:text-primary">{{ getGeneratorName() }}</a>
                </div>
            </div>
        </div>
    </div>
</footer>
