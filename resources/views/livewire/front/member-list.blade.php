<div>
    <div class="flex items-center justify-end gap-4">
        @if(getDirectorySettingsGeneral()['show_filter_member_type'])
            <x-filament::input.wrapper>
                <x-filament::input.select id="memberType" wire:model.live="memberType">
                    <option value="">{{ __('app.pages.member-page.label.all') }}</option>
                    @foreach($types as $k => $v)
                        <option value="{{  $k }}">{{ $v }}</option>
                    @endforeach
                    <option value="activity">{{ __('app.pages.member-page.label.activity') }}</option>
                </x-filament::input.select>
            </x-filament::input.wrapper>
        @endif
        @if(getDirectorySettingsGeneral()['show_filter_search'])
            <x-filament::input.wrapper>
                <x-filament::input
                    type="text"
                    wire:model.live.debounce.250ms="search"
                    placeholder="{{ __('app.pages.member-page.placeholder.search') }}"
                />
            </x-filament::input.wrapper>
        @endif
    </div>
    @if($memberIdChunks)
        @for ($i = 0; $i < $page && $i < $maxPage; $i++)
            @livewire('front.member-list-items', [
                'memberIds' => $memberIdChunks[$i],
            ], key("chunk-{$queryCount}-{$i}"))
        @endfor
    @else
        <div
            class="grid gap-5 font-bold sm:grid-cols-2 md:gap-[30px] lg:grid-cols-4">
            <div class="col-span-full prose dark:prose-invert mx-auto mt-16 text-center">
                {!! __('app.pages.member-page.text_no_result') !!}
                <div class="flex flex-col items-center mt-8 lg:mt-16">
                    <x-front.btn
                        tag="button"
                        wire:click="resetFilter"
                        label="{{ __('app.pages.member-page.reset_filter') }}"
                        type="secondary"
                    />
                </div>
            </div>

        </div>
    @endif

    @if ($this->hasNextPage())
        <div class="mt-8 lg:mt-16 flex flex-col items-center gap-5">
            <x-front.btn
                tag="button"
                wire:click="loadMore"
                label="{{ __('app.pages.member-page.load_more') }}"
                type="secondary"
            />
        </div>
    @endif
</div>

