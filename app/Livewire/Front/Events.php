<?php

namespace App\Livewire\Front;

use App\Models\Event;
use Illuminate\Support\Collection;
use Livewire\Component;

class Events extends Component
{
    public Collection $events;

    public function mount()
    {
        $this->events = Event::query()
            ->whereDate('published_at', '<=', now())
            ->latest('date_start')
            ->get();
    }

    public function render()
    {
        return view('livewire.front.events');
    }
}
