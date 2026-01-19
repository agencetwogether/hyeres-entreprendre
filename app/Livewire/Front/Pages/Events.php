<?php

namespace App\Livewire\Front\Pages;

use App\Models\Event;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class Events extends Component
{
    public int $perPage;
    // public int $perPage = 2;

    public function __construct()
    {
        $this->perPage = getEventSettingsGeneral()['event_per_page'];
    }

    public function load()
    {
        $this->perPage += getEventSettingsGeneral()['event_per_loading'];
        // $this->perPage += 2;
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.front.pages.events', [
            'events' => Event::query()
                ->whereDate('published_at', '<=', now())
                ->latest()
                ->paginate($this->perPage),
            'seo' => new SEOData(
                title: getEventSettingsSeo()['title'],
                description: getEventSettingsSeo()['description'],
                author: getEventSettingsSeo()['author'],
                robots: getEventSettingsSeo()['robots'],
            ),
        ]);
    }
}
