<?php

namespace App\Livewire\Front;

use App\Models\Post;
use Illuminate\Support\Collection;
use Livewire\Component;

class Posts extends Component
{
    public Collection $posts;

    public Post $featuredPost;

    public function mount()
    {
        $this->posts = Post::query()
            // ->whereDate('published_at', '>=', now())
            ->latest('published_at')
            ->limit(5)
            ->get();

        $this->featuredPost = $this->posts->shift();
    }

    public function render()
    {
        return view('livewire.front.posts');
    }
}
