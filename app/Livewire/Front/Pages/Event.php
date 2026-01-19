<?php

namespace App\Livewire\Front\Pages;

use App\Models\Event as EventModel;
use App\Services\RichEditorService;
use Filament\Forms\Components\RichEditor\RichContentRenderer;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Event extends Component
{
    public EventModel $event;

    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.front.pages.event', [
            'seo' => $this->event->getDynamicSEOData(),
        ]);
    }

    public function renderContent(): RichContentRenderer
    {
        return RichContentRenderer::make($this->event->content)
            ->textColors(app(RichEditorService::class)->getColors())
            ->fileAttachmentsDisk('public');
    }
}
