<?php

namespace App\Livewire;

use App\Filament\Pages\Auth\EditProfile;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Livewire\Attributes\On;
use Livewire\Component;

class CompleteProfil extends Component
{
    public bool $visible;

    public string $url;

    public function mount(): void
    {
        $this->url = EditProfile::getUrl();
        $this->visible = $this->getVisibility();
    }

    #[On('refresh')]
    public function refresh(): void
    {
        $this->visible = $this->getVisibility();
    }

    public function getVisibility(): bool
    {
        if (auth()->user()->extra) {

            if (! auth()->user()->extra->firstname || (auth()->user()->isFuneral() && ! Arr::exists(auth()->user()->extra->extra, 'name_funeral'))) {
                return true;
            }

            return false;
        }

        return true;
    }

    public function render(): View
    {
        return view('livewire.complete-profil');
    }
}
