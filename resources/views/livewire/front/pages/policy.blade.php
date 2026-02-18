@php
    use Carbon\CarbonInterval;
@endphp
<x-slot:seo>
    {!! seo($seo ?? null) !!}
</x-slot:seo>

<section>
    <x-front.banner-page
        background-image="{{ getPolicySettingsHeader()['banner'] ? getPolicySettingsHeader()['banner'] : (array_key_exists('show_default_banner', getPolicySettingsHeader()) && getPolicySettingsHeader()['show_default_banner'] ? asset('img/test/bg-patent.png') : null) }}"
        :title="getPolicySettingsHeader()['title']" :subtitle="getPolicySettingsHeader()['description']" />
    @if (getPolicySettingsContent()['content'])
        <div class="py-14 md:py-[100px]">
            <div class="mx-auto max-w-6xl px-4 richeditor-custom text-gray-700">
                {{ $this->renderContent() }}
                <div class="mb-4">
                    @cookieconsentbutton(action: 'reset', label: __('app.pages.policy.manage_cookies'), attributes: ['id' => 'reset-button', 'class' => 'cookiebtn'])
                </div>
                <h3>{{ __('app.pages.policy.list_cookies') }}</h3>

                <div class="relative overflow-x-auto border sm:rounded-sm">
                    @foreach (Cookies::getCategories() as $category)
                        <table class="w-full text-left text-sm text-gray-500">
                            <caption class="bg-white p-5 text-left text-lg font-semibold text-gray-900">
                                {{ $category->title }}
                            </caption>
                            <thead class="bg-gray-50 text-xs uppercase text-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3">{{ __('app.pages.policy.table.cookie') }}</th>
                                    <th scope="col" class="px-6 py-3">{{ __('app.pages.policy.table.description') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3">{{ __('app.pages.policy.table.duration') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($category->getCookies() as $cookie)
                                    <tr class="border-b bg-white">
                                        <th scope="row"
                                            class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                                            {{ $cookie->name }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ $cookie->description }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ CarbonInterval::minutes($cookie->duration)->cascade() }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</section>
