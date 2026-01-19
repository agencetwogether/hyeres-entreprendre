<?php

namespace App\Livewire\Front;

use App\Models\Post;
use Illuminate\View\View;
use Livewire\Component;

class CardPost extends Component
{
    public Post $post;

    public function render(): View
    {
        return view('livewire.front.card-post');
    }
}
