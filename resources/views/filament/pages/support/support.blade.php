<x-filament-panels::page>
    <form class="grid gap-y-6" wire:submit="send">
        {{ $this->form }}
        <div>
            {{ $this->sendAction }}
        </div>
    </form>
</x-filament-panels::page>
