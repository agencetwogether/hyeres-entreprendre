<x-filament-panels::page>
    <div x-data="{ activeTab: '{{ $this->getIntroductionFormTabSlug() }}' }">
        <x-filament::tabs label="Content tabs" class="rounded-b-none">
            <x-filament::tabs.item x-on:click="activeTab = '{{ $this->getIntroductionFormTabSlug() }}'"
                alpine-active="activeTab === '{{ $this->getIntroductionFormTabSlug() }}'" :icon="$this->getIntroductionFormTabIcon()">
                {{ $this->getIntroductionFormTabTitle() }}
            </x-filament::tabs.item>
            <x-filament::tabs.item x-on:click="activeTab = '{{ $this->getPresentationFormTabSlug() }}'"
                alpine-active="activeTab === '{{ $this->getPresentationFormTabSlug() }}'" :icon="$this->getPresentationFormTabIcon()">
                {{ $this->getPresentationFormTabTitle() }}
            </x-filament::tabs.item>
            <x-filament::tabs.item x-on:click="activeTab = '{{ $this->getJoinFormTabSlug() }}'"
                alpine-active="activeTab === '{{ $this->getJoinFormTabSlug() }}'" :icon="$this->getJoinFormTabIcon()">
                {{ $this->getJoinFormTabTitle() }}
            </x-filament::tabs.item>
        </x-filament::tabs>
        <div class="mt-0">
            <x-filament::section x-show="activeTab === '{{ $this->getIntroductionFormTabSlug() }}'"
                class="rounded-t-none">
                <form class="grid gap-y-6" wire:submit="updateIntroduction">
                    {{ $this->editIntroductionForm }}
                    <div>
                        {{ $this->getUpdateIntroductionFormAction() }}
                    </div>
                </form>
            </x-filament::section>
            <x-filament::section x-show="activeTab === '{{ $this->getPresentationFormTabSlug() }}'"
                class="rounded-t-none">
                <form class="grid gap-y-6" wire:submit="updatePresentation">
                    {{ $this->editPresentationForm }}
                    <div>
                        {{ $this->getUpdatePresentationFormAction() }}
                    </div>
                </form>
            </x-filament::section>
            <x-filament::section x-show="activeTab === '{{ $this->getJoinFormTabSlug() }}'" class="rounded-t-none">
                <form class="grid gap-y-6" wire:submit="updateJoin">
                    {{ $this->editJoinForm }}
                    <div>
                        {{ $this->getUpdateJoinFormAction() }}
                    </div>
                </form>
            </x-filament::section>
        </div>
    </div>
</x-filament-panels::page>
