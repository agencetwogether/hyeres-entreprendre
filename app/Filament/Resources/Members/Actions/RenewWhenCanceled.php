<?php

namespace App\Filament\Resources\Members\Actions;

use Filament\Actions\Action;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;

class RenewWhenCanceled extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'renewWhenCanceled';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->successNotificationTitle(fn (Model $record): string => __('app.actions.renew_when_canceled.notification.success', ['ends_at' => $record->onePlanSubscriptions->ends_at->format('d/m/Y')]));

        $this->failureNotificationTitle(__('app.actions.renew_when_canceled.notification.failed'));

        $this->label(__('app.actions.renew_when_canceled.label.button'));

        $this->color('info');

        $this->icon('phosphor-x');

        $this->action(function (array $data, Model $record): void {

            $result = $record->onePlanSubscriptions->renewWhenCanceled();

            if (! $result) {
                $this->failure();

                return;
            }
            $this->success();
        });

        $this->modalHeading(fn (Model $record): string => __('app.actions.renew_when_canceled.modal.heading', ['ends_at' => $record->onePlanSubscriptions->ends_at->format('d/m/Y')]));

        $this->modalDescription(function (Model $record): HtmlString {
            return new HtmlString(__('app.actions.renew_when_canceled.modal.description', ['currentPeriod' => $record->onePlanSubscriptions->starts_at->format('d/m/Y').' - '.$record->onePlanSubscriptions->ends_at->format('d/m/Y')]));
        });

        $this->modalSubmitActionLabel(__('app.actions.renew_when_canceled.label.submit'));

        $this->modalSubmitAction(fn (Action $action): Action => $action->color('info'));

        $this->requiresConfirmation();

        $this->visible(function (Model $record): bool {
            $ends_at = $record->onePlanSubscriptions?->ends_at;
            $canceled_at = $record->onePlanSubscriptions?->canceled_at;

            // Determine how plan was canceled
            $canceledImmediately = filled($ends_at) && filled($canceled_at) && $ends_at->notEqualTo($canceled_at);

            if (
                auth()->user()->can('RenewCanceledSubscription:Member')
                && $canceledImmediately
            ) {
                return true;
            }

            return false;
        });
    }
}
