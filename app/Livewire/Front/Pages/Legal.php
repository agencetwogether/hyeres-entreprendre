<?php

namespace App\Livewire\Front\Pages;

use Filament\Forms\Components\RichEditor\RichContentRenderer;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class Legal extends Component
{
    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.front.pages.legal', [
            'seo' => new SEOData(
                title: getLegalSettingsSeo()['title'],
                description: getLegalSettingsSeo()['description'],
                author: getLegalSettingsSeo()['author'],
                robots: getLegalSettingsSeo()['robots'],
            ),
        ]);
    }

    public function renderContent(): RichContentRenderer
    {
        return RichContentRenderer::make(getLegalSettingsContent()['content']);
    }
}
