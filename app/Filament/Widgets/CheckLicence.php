<?php

namespace App\Filament\Widgets;

use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\Widget;

class CheckLicence extends Widget
{
    use HasWidgetShield;

    protected string $view = 'filament.widgets.check-licence';

    public bool $isValid;

    public string $color;

    public string $description;

    public function mount(): void
    {
        $this->defineDetails();
    }

    private function defineDetails(): void
    {
        $this->isValid = checkLicenceIsValid();

        if ($this->isValid) {
            $this->color = 'success';
            $this->description = __('app.widgets.check_licence.valid.description');
        } else {
            $this->color = 'danger';
            $this->description = __('app.widgets.check_licence.invalid.description');
        }

    }
}
