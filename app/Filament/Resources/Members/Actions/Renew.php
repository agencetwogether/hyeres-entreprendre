<?php

namespace App\Filament\Resources\Members\Actions;

use App\Enums\DiscountRate;
use App\Filament\Resources\Members\Schemas\Components\MemberFields;
use Filament\Actions\Action;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Text;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;
use Laravelcm\Subscriptions\Models\Plan;

class Renew extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'renew';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->successNotificationTitle(fn (Model $record): string => __('app.actions.renew.notification.success', ['plan' => Plan::find($record->onePlanSubscriptions->plan_id)->name, 'member' => $record->firstname.' '.$record->name]));

        $this->failureNotificationTitle(__('app.actions.renew.notification.failed'));

        $this->label(__('app.actions.renew.label.button'));

        $this->color('info');

        $this->icon('phosphor-arrows-clockwise');

        $this->fillForm(fn (Model $record): array => [
            'has_discount' => false,
            'discount_rate' => null,
            'plan_id' => $record->onePlanSubscriptions->plan_id,
        ]);

        $this->schema([
            Fieldset::make(__('app.actions.send_document.label.fieldset_discount'))
                ->schema([
                    Text::make(__('app.actions.renew.placeholder.info_discount'))
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

        $this->action(function (array $data, Model $record): void {

            $subscription = $record->onePlanSubscriptions;
            $result = $subscription->renew($data, $record);

            if (! $result) {
                $this->failure();

                return;
            }
            $this->success();
        });

        // $this->requiresConfirmation();

        $this->modalHeading(fn (Model $record): string => __('app.actions.renew.modal.heading', ['plan' => Plan::find($record->onePlanSubscriptions->plan_id)->name, 'member' => $record->firstname.' '.$record->name]));

        $this->modalDescription(fn (Model $record): HtmlString => new HtmlString(__('app.actions.renew.modal.description', ['currentPeriod' => $record->onePlanSubscriptions->starts_at->format('d/m/Y').' - '.$record->onePlanSubscriptions->ends_at->format('d/m/Y'), 'nextPeriod' => $record->onePlanSubscriptions->formatNextPeriod()])));

        $this->modalSubmitActionLabel(__('app.actions.renew.label.submit'));

        $this->modalSubmitAction(fn (Action $action): Action => $action->color('info'));

        $this->modalAutofocus(false);

        $this->slideOver();

        $this->visible(function (Model $record): bool {
            if (
                auth()->user()->can('RenewSubscription:Member')
                && ($record->onePlanSubscriptions?->almostEnded() || $record->onePlanSubscriptions?->ended())
                && ! $record->onePlanSubscriptions?->canceled()
                && filled($record->onePlanSubscriptions?->payment_received_at)
            ) {
                return true;
            }

            return false;
        });
    }
}
