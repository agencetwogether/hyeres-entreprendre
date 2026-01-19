<?php

namespace App\Actions\MyCompany;

use App\Filament\Resources\Members\Schemas\Components\MemberFields;
use Filament\Actions\Action;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Illuminate\Database\Eloquent\Model;

class EditManager extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'editManager';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->successNotificationTitle(__('app.actions.edit_manager.notification.success'));

        $this->failureNotificationTitle(__('app.actions.edit_manager.notification.failed'));

        $this->label(__('app.actions.edit_manager.label.button'));

        $this->color('warning');

        $this->icon('heroicon-m-pencil-square');

        $this->fillForm(fn (Model $record): array => [
            'avatar' => $record->getFirstMediaUrl('avatar'),
            'firstname' => $record->firstname,
            'name' => $record->name,
            'job' => $record->job,
            'phone' => $record->phone,
            'email' => $record->email,
        ]);

        $this->schema([
            Grid::make(4)
                ->schema([
                    MemberFields::getAvatar()
                        ->columnSpan(1),
                    Group::make()
                        ->schema([
                            MemberFields::getFirstName(),
                            MemberFields::getName(),
                        ])
                        ->columnSpan(3),
                    MemberFields::getJob(),
                    MemberFields::getPhone()
                        ->columnSpan(2),
                    MemberFields::getEmail()
                        ->columnSpan(2),
                ]),
        ]);

        $this->action(function (array $data, Model $record): void {
            $result = $record->update($data);
            if (! $result) {
                $this->failure();

                return;
            }
            $this->success();
        });

        $this->modalHeading(fn (Model $record): string => __('app.actions.edit_manager.modal.heading'));

        $this->modalDescription(__('app.actions.edit_manager.modal.description'));

        $this->modalSubmitActionLabel(__('app.actions.edit_manager.label.submit'));

        $this->modalSubmitAction(fn (Action $action): Action => $action->color('primary'));

        $this->link();

        $this->slideOver();

        $this->modalAutofocus(false);
    }
}
