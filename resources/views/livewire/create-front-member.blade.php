<div class="container mx-auto">
    @if ($sent)
        @include('components.front.create-member-submitted', [
            'textFormSubmittedContent' => $this->renderFormSubmittedContent(),
        ])
    @else
        <div class="mt-20 mb-10 richeditor-custom">
            {{ $this->renderIntroContent() }}
        </div>
        <form wire:submit="create">
            {{ $this->form }}
        </form>
    @endif
    <x-filament-actions::modals />
</div>
