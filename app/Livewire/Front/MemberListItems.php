<?php

namespace App\Livewire\Front;

use App\Models\Member;
use Livewire\Component;

class MemberListItems extends Component
{
    public array $memberIds;

    public function render()
    {
        $members = Member::without('onePlanSubscriptions')->find($this->memberIds)->keyBy('id');

        $orderedMembers = collect($this->memberIds)->map(fn ($id) => $members[$id]);

        return view('livewire.front.member-list-items', [
            'members' => $orderedMembers,
        ]);
    }
}
