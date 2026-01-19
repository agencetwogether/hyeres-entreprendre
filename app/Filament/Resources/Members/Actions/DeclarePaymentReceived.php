<?php

namespace App\Filament\Resources\Members\Actions;

use App\Enums\PaymentMethod;
use App\Mails\PaymentReceived;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class DeclarePaymentReceived extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'declarePaymentReceived';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->successNotificationTitle(__('app.actions.declare_payment_received.notification.success'));

        $this->failureNotificationTitle(__('app.actions.declare_payment_received.notification.failed'));

        $this->label(__('app.actions.declare_payment_received.label.button'));

        $this->color('success');

        $this->icon('phosphor-hand-coins');

        $this->schema([
            DatePicker::make('payment_received_at')
                ->label(__('app.actions.declare_payment_received.form.payment_received_at'))
                ->native(false)
                ->displayFormat(getDisplayDate())
                ->closeOnDateSelection()
                ->prefixIcon('phosphor-calendar')
                ->maxDate(Carbon::today()->endOfDay())
                ->default(now()),
            Select::make('payment_mode')
                ->label(__('app.actions.declare_payment_received.form.payment_mode'))
                ->native(false)
                ->selectablePlaceholder(false)
                ->options(PaymentMethod::class)
                ->required(),
        ]);

        $this->action(function (array $data, Model $record): void {

            $paymentReceivedAt = Carbon::createFromFormat('Y-m-d', $data['payment_received_at']);
            // Save to subscription
            $record->onePlanSubscriptions->update([
                'payment_received_at' => $paymentReceivedAt,
            ]);
            $record->update([
                'is_published' => true,
            ]);

            // Save invoice
            $result = $record->onePlanSubscriptions->invoices()->create([
                'amount' => $record->onePlanSubscriptions->plan->price,
                'discount_rate' => $record->onePlanSubscriptions->discount_rate,
                'payment_received_at' => $paymentReceivedAt,
                'payment_mode' => $data['payment_mode'],
                'starts_at' => $record->onePlanSubscriptions->starts_at,
                'ends_at' => $record->onePlanSubscriptions->ends_at,
            ]);

            if (! $result) {
                $this->failure();

                return;
            }
            $record->refresh();

            Mail::to($record->email, $record->firstname.' '.$record->name)
                ->send(new PaymentReceived($data, $record, $result));

            $this->success();
            $this->dispatch('refreshTableMembers');
        });

        $this->modalHeading(fn (Model $record): string => __('app.actions.declare_payment_received.modal.heading'));

        $this->modalDescription(__('app.actions.declare_payment_received.modal.description'));

        $this->modalSubmitActionLabel(__('app.actions.declare_payment_received.label.submit'));

        $this->modalSubmitAction(fn (Action $action): Action => $action->color('success'));

        $this->modalAutofocus(false);

        $this->slideOver();

        $this->hidden(function (Model $record): bool {
            if (auth()->user()->cannot('DeclarePaymentReceivedSubscription:Member')) {
                return true;
            }

            if (
                $record->onePlanSubscriptions == null
                || $record->onePlanSubscriptions?->inactive()
                || $record->onePlanSubscriptions?->paid()
            ) {
                return true;
            }

            return false;
        });
    }
}
