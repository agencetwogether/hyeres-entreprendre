<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Resources\Posts\PostResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    public function getTitle(): string
    {
        return __('app.posts.page.title_edit', ['title' => $this->record->title]);
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->link()
                ->modalHeading(__('app.posts.table.action.delete.modal.heading', ['title' => $this->record->title]))
                ->modalDescription(__('app.posts.table.action.delete.modal.description'))
                ->successNotificationTitle(__('app.posts.table.action.delete.modal.notification_success', ['title' => $this->record->title])),
        ];
    }

    protected function getSaveFormAction(): Action
    {
        return parent::getSaveFormAction()
            ->label(__('app.posts.table.action.edit.submit'));
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return __('app.posts.table.action.edit.notification_success');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
