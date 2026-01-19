<?php

namespace App\Livewire\Front;

use App\Models\Member;
use Illuminate\View\View;
use Livewire\Component;

class CardMember extends Component
{
    public Member $member;

    public function render(): View
    {
        return view('livewire.front.card-member');
    }
}
