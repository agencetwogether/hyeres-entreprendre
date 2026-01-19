<?php

namespace App\Livewire\Front\Pages;

use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class Members extends Component
{
    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.front.pages.members', [
            'seo' => new SEOData(
                title: getDirectorySettingsSeo()['title'],
                description: getDirectorySettingsSeo()['description'],
                author: getDirectorySettingsSeo()['author'],
                robots: getDirectorySettingsSeo()['robots'],
            ),
        ]);
    }
}
