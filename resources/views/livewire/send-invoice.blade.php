<div>
    @if ($this->sendAction->isVisible())
        {{ $this->sendAction }}
    @endif
    <x-filament-actions::modals />
</div>
