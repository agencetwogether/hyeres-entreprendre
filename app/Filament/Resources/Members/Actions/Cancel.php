<?php

namespace App\Filament\Resources\Members\Actions;

use Filament\Actions\Action;
use Filament\Forms\Components\Toggle;
use Filament\Support\Enums\Width;
use Illuminate\Database\Eloquent\Model;
use Laravelcm\Subscriptions\Models\Plan;

class Cancel extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'cancel';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->successNotificationTitle(fn (Model $record): string => __('app.actions.cancel.notification.success', ['plan' => Plan::find($record->onePlanSubscriptions->plan_id)->name, 'member' => $record->firstname.' '.$record->name]));

        $this->failureNotificationTitle(__('app.actions.cancel.notification.failed'));

        $this->label(__('app.actions.cancel.label.button'));

        $this->color('gray');

        $this->icon('phosphor-x');

        $this->schema([
            Toggle::make('immediately')
                ->label(__('app.actions.cancel.form.immediately'))
                ->helperText(__('app.actions.cancel.form.immediately_helper')),
        ]);

        $this->action(function (array $data, Model $record): void {
            // Update invoice in case cancel immediately
            if ($data['immediately']) {
                // Check if invoices exist
                $invoices = $record->onePlanSubscriptions->invoices;
                if ($invoices->isNotEmpty()) {
                    $invoice = $invoices
                        ->where('starts_at', $record->onePlanSubscriptions->starts_at)
                        ->where('ends_at', $record->onePlanSubscriptions->ends_at)
                        ->first();

                    if ($invoice) {
                        $invoice->update([
                            'ends_at' => now(),
                        ]);
                    }
                }
                $record->update([
                    'is_published' => false,
                ]);
            }

            $result = $record->onePlanSubscriptions->cancel($data['immediately']);

            if (! $result) {
                $this->failure();

                return;
            }
            $this->success();
        });

        $this->requiresConfirmation();

        $this->modalHeading(fn (Model $record): string => __('app.actions.cancel.modal.heading', ['plan' => Plan::find($record->onePlanSubscriptions->plan_id)->name, 'member' => $record->firstname.' '.$record->name]));

        $this->modalDescription(__('app.actions.cancel.modal.description'));

        $this->modalSubmitActionLabel(__('app.actions.cancel.label.submit'));

        $this->modalSubmitAction(fn (Action $action): Action => $action->color('danger'));

        $this->modalIconColor('danger');

        $this->modalAutofocus(false);

        $this->modalWidth(Width::Large);

        $this->visible(function (Model $record): bool {
            if (
                auth()->user()->can('CancelSubscription:Member')
                && (
                    $record->onePlanSubscriptions?->active()
                    && $record->onePlanSubscriptions?->canceled_at == null
                )
            ) {
                return true;
            }

            return false;
        });
    }
}
