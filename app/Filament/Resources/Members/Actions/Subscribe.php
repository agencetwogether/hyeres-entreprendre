<?php

namespace App\Filament\Resources\Members\Actions;

use App\Enums\DiscountRate;
use App\Filament\Resources\Members\Schemas\Components\MemberFields;
use App\Models\Member;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Text;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Database\Eloquent\Model;
use Laravelcm\Subscriptions\Models\Plan;

class Subscribe extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'subscribe';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->successNotificationTitle(fn (Model $record): string => __('app.actions.subscribe.notification.success', ['member' => $record->getFullName(), 'plan' => $record->onePlanSubscriptions->plan->name]));

        $this->failureNotificationTitle(__('app.actions.subscribe.notification.failed'));

        $this->label(__('app.actions.subscribe.label.button'));

        $this->color('success');

        $this->icon('phosphor-plus');

        $this->fillForm([
            'has_discount' => false,
            'discount_rate' => null,
        ]);

        $this->schema([
            Fieldset::make(__('app.actions.send_document.label.fieldset_discount'))
                ->schema([
                    Text::make(__('app.actions.subscribe.placeholder.info_discount'))
                        ->color('neutral')
                        ->columnSpanFull(),
                    Radio::make('has_discount')
                        ->label(__('app.actions.send_document.label.has_discount'))
                        ->hiddenLabel()
                        ->boolean()
                        ->inline()
                        ->live(),
                    Select::make('discount_rate')
                        ->label(__('app.actions.send_document.label.discount_rate'))
                        ->native(false)
                        ->selectablePlaceholder(false)
                        ->options(DiscountRate::class)
                        ->requiredIfAccepted('has_discount')
                        ->validationMessages([
                            'required_if_accepted' => __('app.actions.send_document.validation.discount_rate'),
                        ])
                        ->live()
                        ->visible(fn (Get $get): bool => $get('has_discount')),
                ]),
            MemberFields::getPlans(),
        ]);

        $this->action(function (array $data, Member $record): void {

            $plan = Plan::find($data['plan_id']);

            $subscription = $record->newPlanSubscription($plan->name, $plan, Carbon::now()->startOfYear());

            // check if a discount have to apply
            $hasDiscount = $data['has_discount'];
            if ($hasDiscount) {
                $subscription->update([
                    'discount_rate' => $data['discount_rate'],
                ]);
            }

            /*if (! $subscription) {
                $this->failure();
                return;
            }*/

            $record->refresh();
            $this->success();

        });

        $this->modalHeading(fn (Model $record): string => __('app.actions.subscribe.modal.heading', ['member' => $record->firstname.' '.$record->name]));

        $this->modalDescription(__('app.actions.subscribe.modal.description'));

        $this->modalSubmitActionLabel(__('app.actions.subscribe.label.submit'));

        $this->modalSubmitAction(fn (Action $action): Action => $action->color('success'));

        $this->modalAutofocus(false);

        $this->slideOver();

        $this->visible(function (Model $record): bool {
            if (
                auth()->user()->can('SubscribeSubscription:Member')
                && blank($record->onePlanSubscriptions)
            ) {
                return true;
            }

            return false;
        });
    }
}
