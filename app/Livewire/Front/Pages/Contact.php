<?php

namespace App\Livewire\Front\Pages;

use App\Services\RichEditorService;
use Filament\Forms\Components\RichEditor\RichContentRenderer;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class Contact extends Component
{
    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.front.pages.contact', [
            'seo' => new SEOData(
                title: getContactSettingsSeo()['title'],
                description: getContactSettingsSeo()['description'],
                author: getContactSettingsSeo()['author'],
                robots: getContactSettingsSeo()['robots'],
            ),
        ]);
    }

    public function renderContent(): RichContentRenderer
    {
        return RichContentRenderer::make(getContactSettingsContent()['presentation']['text'])
            ->textColors(app(RichEditorService::class)->getColors());
    }
}
