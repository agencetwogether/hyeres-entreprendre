<?php

namespace App\Filament\Pages\Auth;

use DiogoGPinto\AuthUIEnhancer\Pages\Auth\Concerns\HasCustomLayout;
use Filament\Auth\Pages\Login as BasePage;

class Login extends BasePage
{
    use HasCustomLayout;

    public function mount(): void
    {
        parent::mount();

        if (app()->isLocal()) {
            $this->form->fill([
                'email' => 'max.ellis@free.fr',
                'password' => 'password',
                'remember' => true,
            ]);
        }
    }
}
