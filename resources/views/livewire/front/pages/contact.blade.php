<x-slot:seo>
    {!! seo($seo ?? null) !!}
</x-slot:seo>

<section>
    <x-front.banner-page
        background-image="{{ getContactSettingsHeader()['banner'] ? getContactSettingsHeader()['banner'] : (array_key_exists('show_default_banner', getContactSettingsHeader()) && getContactSettingsHeader()['show_default_banner'] ? asset('img/test/bg-patent.png') : null) }}"
        :title="getContactSettingsHeader()['title']" :subtitle="getContactSettingsHeader()['description']" />

    @if (filled(getContactSettingsContent()['presentation']['text']) &&
            getContactSettingsContent()['presentation']['text'] !== '<p></p>')
        <section class="py-20 md:py-28">
            <div class="mx-auto max-w-4xl px-4">
                <div class="group grid-cols-2 overflow-hidden rounded-md bg-white dark:bg-slate-700 sm:grid shadow-lg">
                    @if (filled(getContactSettingsContent()['presentation']['image']))
                        <div class="overflow-hidden">
                            <img src="{{ getContactSettingsContent()['presentation']['image'] }}" alt=""
                                class="h-full w-full min-h-[450px] object-cover transition duration-500 group-hover:scale-125" />
                        </div>
                    @endif

                    <div class="space-y-4 p-5 lg:py-20 lg:px-16 richeditor-custom text-gray-700 dark:text-gray-300">
                        {{ $this->renderContent() }}
                    </div>

                </div>
            </div>
        </section>
    @endif

    <section class="py-14 lg:py-[100px]">
        <div class="mx-auto max-w-6xl px-4">
            <div class="grid lg:grid-cols-3 gap-20">
                <div class="flex flex-col gap-6 ">
                    @if (getContactSettingsContent()['show_phone'])
                        <x-front.card-contact icon="phosphor-phone" text="{{ __('app.pages.contact.call_us') }}"
                            value="{{ phone(getClientPhone())->formatNational() }}" type="phone" :link="true" />
                    @endif
                    @if (getContactSettingsContent()['show_email'])
                        <x-front.card-contact icon="phosphor-paper-plane-tilt"
                            text="{{ __('app.pages.contact.write_us') }}" value="{{ getClientEmail() }}" type="email"
                            :link="true" />
                    @endif
                    @if (getContactSettingsContent()['show_postal_address'])
                        <x-front.card-contact icon="phosphor-map-pin" text="{{ __('app.pages.contact.come_in') }}"
                            value="{{ getClientAddress() . ' ' . getClientPostalCode() . ' ' . getClientCity() }}"
                            :link="false" />
                    @endif
                </div>

                <div class="lg:col-span-2">
                    <livewire:contact-form />
                </div>
            </div>
        </div>
    </section>
</section>
