<?php

namespace App\Filament\Resources\Plans\Pages;

use App\Filament\Resources\Plans\PlanResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreatePlan extends CreateRecord
{
    protected static string $resource = PlanResource::class;

    protected static bool $canCreateAnother = false;

    public function getTitle(): string
    {
        return __('app.plans.page.title_create');
    }

    protected function getCreateFormAction(): Action
    {
        return parent::getCreateFormAction()
            ->label(__('app.plans.table.action.create.submit'));
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return __('app.plans.table.action.create.notification_success');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
