<?php

namespace App\Livewire\Front\Pages;

use App\Models\Post;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class Posts extends Component
{
    public int $perPage;
    // public int $perPage = 2;

    public function __construct()
    {
        $this->perPage = getPostSettingsGeneral()['post_per_page'];
    }

    public function load()
    {
        $this->perPage += getPostSettingsGeneral()['post_per_loading'];
        // $this->perPage += 2;
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.front.pages.posts', [
            'posts' => Post::query()
                // ->whereDate('published_at', '>=', now())
                ->latest('published_at')
                ->paginate($this->perPage),
            'seo' => new SEOData(
                title: getPostSettingsSeo()['title'],
                description: getPostSettingsSeo()['description'],
                author: getPostSettingsSeo()['author'],
                robots: getPostSettingsSeo()['robots'],
            ),
        ]);
    }
}
