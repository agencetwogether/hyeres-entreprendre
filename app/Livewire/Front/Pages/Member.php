<?php

namespace App\Livewire\Front\Pages;

use App\Models\Member as MemberModel;
use App\Services\RichEditorService;
use Filament\Forms\Components\RichEditor\RichContentRenderer;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Member extends Component
{
    public MemberModel $member;

    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.front.pages.member')->with([
            'seo' => $this->member->getDynamicSEOData(),
        ]);
    }

    public function renderContent(): RichContentRenderer
    {
        return RichContentRenderer::make($this->member->company_description)
            ->textColors(app(RichEditorService::class)->getColors())
            ->fileAttachmentsDisk('public');
    }
}
