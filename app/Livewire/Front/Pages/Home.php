<?php

namespace App\Livewire\Front\Pages;

use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class Home extends Component
{
    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.front.pages.home', [
            'seo' => new SEOData(
                title: getHomeSettingsSeo()['title'],
                description: getHomeSettingsSeo()['description'],
                author: getHomeSettingsSeo()['author'],
                robots: getHomeSettingsSeo()['robots'],
            ),
        ]);
    }
}
