<?php

namespace App\Livewire\Front;

use App\Enums\MemberType;
use App\Models\Member;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class MemberList extends Component
{
    public int $perPage;

    public $memberIdChunks = [];

    public int $page = 1;

    public int $maxPage = 1;

    public string $memberType = '';

    public string $search = '';

    public int $queryCount = 0;

    public array $types;

    public function mount()
    {
        $this->perPage = getDirectorySettingsGeneral()['item_per_page'];
        $this->types = MemberType::options();
        $this->prepareChunks();
    }

    public function render()
    {
        return view('livewire.front.member-list');
    }

    public function updatedMemberType()
    {
        $this->prepareChunks();
    }

    public function updatedSearch()
    {
        $this->prepareChunks();
    }

    public function loadMore()
    {
        if ($this->hasNextPage()) {
            $this->page++;
        }
    }

    public function prepareChunks()
    {
        $this->memberIdChunks = Member::query()
            ->where('is_published', true)
            /*->whereHas('onePlanSubscriptions', function (Builder $query) {
                $query->findActive();
            })*/
            ->inRandomOrder();

        if ($this->memberType && $this->memberType !== 'activity') {
            $this->memberIdChunks = $this->memberIdChunks->where('member_type', $this->memberType);
        }
        if ($this->search) {
            $this->memberIdChunks = $this->memberIdChunks
                ->where(function (Builder $query) {
                    $query->orWhere('firstname', 'like', '%'.$this->search.'%')
                        ->orWhere('name', 'like', '%'.$this->search.'%')
                        ->orWhere('company_name', 'like', '%'.$this->search.'%')
                        ->orWhere('company_activity', 'like', '%'.$this->search.'%');
                });
        }

        $this->memberIdChunks = $this->memberIdChunks->pluck('id')
            ->chunk($this->perPage)
            ->toArray();

        $this->page = 1;

        $this->maxPage = count($this->memberIdChunks);

        $this->queryCount++;
    }

    public function hasNextPage()
    {
        return $this->page < $this->maxPage;
    }

    public function resetFilter()
    {
        $this->memberType = '';
        $this->search = '';
        $this->prepareChunks();
    }
}
