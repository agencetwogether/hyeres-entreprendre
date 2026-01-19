<?php

namespace App\Livewire\Front\Pages;

use App\Models\Post as PostModel;
use App\Services\RichEditorService;
use Filament\Forms\Components\RichEditor\RichContentRenderer;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Post extends Component
{
    public PostModel $post;

    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.front.pages.post', [
            'seo' => $this->post->getDynamicSEOData(),
        ]);
    }

    public function renderContent(): RichContentRenderer
    {
        return RichContentRenderer::make($this->post->content)
            ->textColors(app(RichEditorService::class)->getColors())
            ->fileAttachmentsDisk('public');
    }
}
