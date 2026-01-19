<?php

namespace App\Livewire\Front;

use App\Models\Event;
use Illuminate\View\View;
use Livewire\Component;

class CardEvent extends Component
{
    public Event $event;

    public function render(): View
    {
        return view('livewire.front.card-event');
    }
}
