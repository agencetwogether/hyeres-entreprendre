@php
    $is_partner = $member->onePlanSubscriptions?->name == 'Partenaire';
@endphp
<div
    class="max-w-2xl mx-4 sm:max-w-sm md:max-w-sm lg:max-w-sm xl:max-w-sm sm:mx-auto md:mx-auto lg:mx-auto xl:mx-auto mt-16 bg-white dark:bg-slate-700 shadow-xl rounded-lg text-gray-600 dark:text-white">

    <div
        @class([
            "relative rounded-t-lg h-32 overflow-hidden border-b",
            "bg-primary-50 dark:bg-primary-600" => $is_partner,
            "bg-secondary-50 dark:bg-secondary-600" => !$is_partner,
        ])>
        <div class="flex h-full w-full cursor-default">
            {{--<h2 @class([
                    "text-full my-auto font-semibold uppercase tracking-wider opacity-5",
                    "text-primary dark:text-primary-950" => renew_when_canceled,
                    "text-secondary dark:text-secondary-950" => !$is_partner,
                ])
            >
                {{ $is_partner ? 'Partenaire' : 'Adhérent' }}
            </h2>--}}
            @if($is_partner)
                <svg class="w-full font-semibold uppercase tracking-wider opacity-5 fill-primary dark:fill-primary-950"
                     viewBox="0 0 110 18">
                    <text x="0" y="15">Partenaire</text>
                </svg>
            @else
                <svg
                    class="w-full font-semibold uppercase tracking-wider opacity-5 fill-secondary dark:fill-secondary-950"
                    viewBox="0 0 96 18">
                    <text x="0" y="15">Adhérent</text>
                </svg>
            @endif
        </div>

        <span
            @class([
                "absolute z-10 text-base top-0 right-0 px-6 py-2 transition duration-300 ease-in-out rounded-bl-lg cursor-default text-white",
                "bg-primary" => $is_partner,
                "bg-secondary" => !$is_partner,
            ])
        >{{ $is_partner ? 'Partenaire' : 'Adhérent' }}</span>
    </div>

    <div
        class="mx-auto w-32 h-32 relative -mt-16 border-4 border-white dark:border-slate-700 rounded-full overflow-hidden">
        <img class="object-cover object-center h-32"
             src="{{ $member->getFirstMediaUrl('avatar') }}"
             alt='Woman looking front'>
    </div>
    <div class="text-center mt-2">
        <h2 @class([
                "text-2xl font-semibold mb-2",
                "text-primary" => $is_partner,
                "text-secondary" => !$is_partner,
            ])>
            {{ $member->getFullName() }}
        </h2>
        <p class="text-xl">{{ $member->company_name }}</p>
    </div>
    <div class="my-6 p-2">
        <img class="light-mode-btn hidden object-cover object-center w-full mx-auto"
             src="{{ $member->getFirstMediaUrl('company_logo', 'card-dark') }}"
             alt="{{ $member->company_name }}">
        <img class="dark-mode-btn object-cover object-center w-full mx-auto"
             src="{{ $member->getFirstMediaUrl('company_logo', 'card') }}"
             alt="{{ $member->company_name }}">
    </div>
    <div class="flex flex-wrap gap-4 p-4">

        @if($member->phone)
            <div class="flex gap-2">
                <x-icon
                    @class([
                        "h-6 w-6",
                        "text-primary" => $is_partner,
                        "text-secondary" => !$is_partner,
                    ])
                    name="phosphor-phone"/>
                <a href="tel:{{ phone($member->phone)->formatNational() }}">{{ phone($member->phone)->formatNational() }}</a>
            </div>
        @endif
        @if($member->email)
            <div class="flex gap-2">
                <x-icon
                    @class([
                        "h-6 w-6",
                        "text-primary" => $is_partner,
                        "text-secondary" => !$is_partner,
                    ])
                    name="phosphor-at"/>
                <a href="mailto:{{ $member->email }}">{{ $member->email }}</a>
            </div>
        @endif
        @if($member->company_website)
            <div class="flex gap-2">
                <x-icon
                    @class([
                        "h-6 w-6",
                        "text-primary" => $is_partner,
                        "text-secondary" => !$is_partner,
                    ])
                    name="phosphor-globe"/>
                <a target="_blank" href="{{ $member->company_website }}">Site</a>
            </div>
        @endif
    </div>
    <div class="p-4 border-t mx-8 mt-2 text-center">
        <x-front.btn
            href="{{ route('member.show', ['member' => $member]) }}"
            label="Consulter"
            type="secondary"
        />
    </div>
</div>
