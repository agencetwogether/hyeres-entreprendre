<?php

namespace App\Livewire\Front\Pages;

use Filament\Forms\Components\RichEditor\RichContentRenderer;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class Policy extends Component
{
    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.front.pages.policy', [
            'seo' => new SEOData(
                title: getPolicySettingsSeo()['title'],
                description: getPolicySettingsSeo()['description'],
                author: getPolicySettingsSeo()['author'],
                robots: getPolicySettingsSeo()['robots'],
            ),
        ]);
    }

    public function renderContent(): RichContentRenderer
    {
        return RichContentRenderer::make(getPolicySettingsContent()['content']);
    }
}
