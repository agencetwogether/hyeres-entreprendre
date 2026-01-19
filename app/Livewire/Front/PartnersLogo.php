<?php

namespace App\Livewire\Front;

use App\Enums\MemberType;
use App\Models\Member;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Livewire\Component;

class PartnersLogo extends Component
{
    public Collection $members;

    public function mount()
    {
        /*$this->members = Member::whereHas('onePlanSubscriptions', function (Builder $query) {
            $query->where('name->fr', 'Partenaire');
            // $query->where('slug', 'like', '%partenaire%');
        })
            ->where('is_published', true)
            ->get();
        */
        $this->members = Member::query()
            ->where('member_type', MemberType::PARTNER)
            ->orWhere('member_type', MemberType::OFFICE)
            ->where('is_published', true)
            ->whereHas('onePlanSubscriptions', function (Builder $query) {
                $query->findActive();
            })
            ->get();

    }

    public function render()
    {
        return view('livewire.front.partners-logo');
    }
}
