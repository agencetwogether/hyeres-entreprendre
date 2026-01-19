@php
    use App\Enums\SocialNetwork;
    use App\Enums\MemberType;
    $is_partner = $member->member_type == MemberType::PARTNER;
    $is_member = $member->member_type == MemberType::MEMBER;
    $is_office = $member->member_type == MemberType::OFFICE;
@endphp
<x-slot:seo>
    {!! seo($seo ?? null) !!}
</x-slot>
<section>
    <x-front.banner-page background-image="{{ asset('background-member.png') }}" :as-patern="true"
        title="{{ strtoupper($member->company_name) }}" subtitle="{{ $member->getFullName() }}" />
    <div class="mx-auto max-w-6xl px-4 py-20">
        <div class="flex flex-col lg:flex-row gap-10 items-start justify-stretch">
            <div class="w-full">
                <div class="flex items-center justify-center">
                    <div class="w-full">
                        @if (filled($member->company_activity))
                            <div
                                class="md:grid md:grid-cols-2 md:space-y-0 space-y-1 py-4 border-b border-slate-200 dark:border-slate-700">
                                <p class="font-semibold text-primary">
                                    {{ __('app.pages.member-page.activity') }}
                                </p>
                                <p class="dark:text-white">
                                    {{ $member->company_activity }}
                                </p>
                            </div>
                        @endif
                        @if (filled($member->job))
                            <div
                                class="md:grid md:grid-cols-2 md:space-y-0 space-y-1 py-4 border-b border-slate-200 dark:border-slate-700">
                                <p class="font-semibold text-primary">
                                    {{ __('app.pages.member-page.job') }}
                                </p>
                                <p class="dark:text-white">
                                    {{ $member->job }}
                                </p>
                            </div>
                        @endif
                        @if (filled($member->company_street) || filled($member->company_postal_code) || $member->company_city)
                            <div
                                class="md:grid md:grid-cols-2 md:space-y-0 space-y-1 py-4 border-b border-slate-200 dark:border-slate-700">
                                <p class="font-semibold text-primary">
                                    {{ __('app.pages.member-page.address') }}
                                </p>
                                <div class="dark:text-white">
                                    <p>{{ $member->company_street }}</p>
                                    <p>{{ $member->company_ext_street }}</p>
                                    <p>{{ $member->company_postal_code }} {{ $member->company_city }}</p>
                                </div>
                            </div>
                        @endif
                        @if (filled($member->phone))
                            <div
                                class="md:grid md:grid-cols-2 md:space-y-0 space-y-1 py-4 border-b border-slate-200 dark:border-slate-700">
                                <p class="font-semibold text-primary">
                                    {{ __('app.pages.member-page.phone') }}
                                </p>
                                <a class="dark:text-white" href="tel:{{ $member->phone }}">
                                    {{ phone($member->phone)->formatNational() }}
                                </a>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
            <div class="flex flex-col w-full gap-8">
                <img class="w-full mx-auto" src="{{ $member->getFirstMediaUrl('company_logo', 'webp') }}"
                    alt="{{ $member->company_name }}">

                <ul class="flex w-full flex-wrap gap-4">
                    @if (filled($member->email))
                        <li>
                            <a class="flex h-16 w-16 items-center justify-center rounded-lg border border-transparent transition duration-500 hover:border-secondary bg-secondary-50 dark:bg-gray-dark md:h-20 md:w-20"
                                href="mailto:{{ $member->email }}">
                                <x-icon class="h-8 w-8 text-primary" name="phosphor-at" />
                            </a>
                        </li>
                    @endif
                    @if (filled($member->company_website))
                        <li>
                            <a class="flex h-16 w-16 items-center justify-center rounded-lg border border-transparent transition duration-500 hover:border-secondary bg-secondary-50 dark:bg-gray-dark md:h-20 md:w-20"
                                href="{{ $member->company_website }}" target="_blank">
                                <x-icon class="h-8 w-8 text-primary" name="phosphor-globe" />
                            </a>
                        </li>
                    @endif
                    @if (!empty($member->company_socials))
                        @foreach ($member->company_socials as $item)
                            <li>
                                <a class="flex h-16 w-16 items-center justify-center rounded-lg border border-transparent transition duration-500 hover:border-secondary bg-secondary-50 dark:bg-gray-dark md:h-20 md:w-20"
                                    href="{{ url($item['account']) }}" target="_blank">
                                    <x-icon class="h-8 w-8 text-primary" :name="SocialNetwork::from($item['name'])->getIcon()" />
                                </a>
                            </li>
                        @endforeach
                    @endif
                </ul>

            </div>
        </div>

        <div class="py-14 md:py-20">
            <h3 class="mb-7 text-xl font-extrabold text-black dark:text-white sm:text-2xl">
                {{ __('app.pages.member-page.presentation') }}</h3>
            <div class="richeditor-custom text-gray-700 max-w-full">
                {{ $this->renderContent() }}
            </div>
        </div>
    </div>
    <div class="text-center pb-20">
        <x-front.btn href="{{ route('members.index') }}" :label="__('app.pages.member-page.back_to_directory')" type="secondary"
            icon="phosphor-arrow-left" />
    </div>

</section>
