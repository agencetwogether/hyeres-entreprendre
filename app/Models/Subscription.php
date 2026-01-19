<?php

namespace App\Models;

use App\Enums\DiscountRate;
use App\Mails\RenewSubscription;
use App\Mails\RenewSubscriptionCanceledImmediately;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Laravelcm\Subscriptions\Models\Plan;
use Laravelcm\Subscriptions\Models\Subscription as BaseSubscription;
use LogicException;

class Subscription extends BaseSubscription
{
    protected $fillable = [
        'subscriber_id',
        'subscriber_type',
        'plan_id',
        'discount_rate',
        'payment_received_at',
        'slug',
        'name',
        'description',
        'trial_ends_at',
        'starts_at',
        'ends_at',
        'cancels_at',
        'canceled_at',
    ];

    protected $casts = [
        'subscriber_type' => 'string',
        'slug' => 'string',
        'payment_received_at' => 'datetime',
        'trial_ends_at' => 'datetime',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'cancels_at' => 'datetime',
        'canceled_at' => 'datetime',
        'deleted_at' => 'datetime',
        'discount_rate' => DiscountRate::class,
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */
    /**
     * @return HasMany<Invoice>
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'subscription_id', 'id');
    }

    /*
    |--------------------------------------------------------------------------
    | UTILITIES
    |--------------------------------------------------------------------------
    */
    public function calculateNextPeriod(): array
    {
        $subscription = $this;

        return [
            'start' => $subscription->ends_at,
            'end' => $subscription->ends_at->copy()->endOfYear()->addDay(),
        ];
    }

    public function formatNextPeriod(): string
    {
        $nextPeriod = $this->calculateNextPeriod();

        return $nextPeriod['start']->format('d/m/Y').' - '.$nextPeriod['end']->format('d/m/Y');

    }

    public function almostEnded(): bool
    {
        // Before est la date de fin MOINS 1 mois
        $before = $this->ends_at->copy()->subMonths();
        $end = $this->ends_at;

        // $today = Carbon::parse('2025-12-24');
        $today = Carbon::today();

        return $today->between($before, $end);
    }

    public function paid(): bool
    {
        return filled($this->payment_received_at);
    }

    public function changePlan(Plan $plan, ?int $discountRate = null): self
    {
        // If plans does not have the same billing frequency
        // (e.g., invoice_interval and invoice_period) we will update
        // the billing dates starting today, and since we are basically creating
        // a new billing cycle, the usage data will be cleared.
        if (
            $this->plan->invoice_interval !== $plan->invoice_interval
            || $this->plan->invoice_period !== $plan->invoice_period
        ) {
            $this->setNewPeriod($plan->invoice_interval, $plan->invoice_period);
            $this->usage()->delete();
        }

        // Attach new plan to subscription
        $this->plan_id = $plan->getKey();
        $this->name = $plan->name;
        $this->discount_rate = $discountRate;
        $this->generateSlug();
        $this->save();

        return $this;
    }

    /**
     * Renew subscription period.
     *
     * @return $this
     *
     * @throws LogicException
     */
    public function renew(array $data = [], ?Model $record = null): self
    {
        if ($this->ended() && $this->canceled()) {
            throw new LogicException('Unable to renew canceled ended subscription.');
        }

        $subscription = $this;

        DB::transaction(function () use ($subscription, $data, $record): void {
            // Clear usage data
            $subscription->usage()->delete();

            // Renew period
            $nextPeriod = $this->calculateNextPeriod();

            if ($subscription->plan_id != $data['plan_id']) {
                $plan = Plan::find($data['plan_id']);
                $subscription->plan_id = $plan->getKey();
                $subscription->name = $plan->name;
                $subscription->generateSlug();
            }

            $subscription->starts_at = $nextPeriod['start'];
            $subscription->ends_at = $nextPeriod['end'];
            $subscription->canceled_at = null;
            $subscription->payment_received_at = null;
            $subscription->discount_rate = array_key_exists('discount_rate', $data) ? $data['discount_rate'] : null;

            $subscription->save();

            // Envoyer mail notification
            Mail::to($record->email, $record->getFullName())
                ->send(new RenewSubscription($data, $record));
            //
        });

        return $this;
    }

    public function renewWhenCanceledImmediately(array $data = [], ?Model $record = null): self
    {
        $subscription = $this;

        DB::transaction(function () use ($subscription, $data, $record): void {
            // Clear usage data
            $subscription->usage()->delete();

            // Retrieve current dates
            $ends_at = $subscription->ends_at;
            $canceled_at = $subscription->canceled_at;

            // Determine how plan was canceled
            $canceledImmediately = $ends_at->eq($canceled_at);

            if ($canceledImmediately) {
                // Redefine period based of starts_at
                $subscription->starts_at = $ends_at->copy()->startOfDay();
                $subscription->ends_at = $ends_at->copy()->endOfYear()->addDay()->startOfDay();

                if ($subscription->plan_id != $data['plan_id']) {
                    $plan = Plan::find($data['plan_id']);
                    $subscription->plan_id = $plan->getKey();
                    $subscription->name = $plan->name;
                    $subscription->generateSlug();
                }

                $subscription->canceled_at = null;
                $subscription->payment_received_at = null;
                $subscription->discount_rate = array_key_exists('discount_rate', $data) ? $data['discount_rate'] : null;

                $subscription->save();

                // Envoyer mail notification
                Mail::to($record->email, $record->getFullName())
                    ->send(new RenewSubscriptionCanceledImmediately($data, $record));
                //
            }

        });

        return $this;
    }

    public function renewWhenCanceled(): self
    {
        $subscription = $this;

        DB::transaction(function () use ($subscription): void {
            $subscription->canceled_at = null;
            $subscription->save();
        });

        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    #[Scope]
    protected function findActive(Builder $query): void
    {
        $query
            ->where('ends_at', '>', Carbon::now())
            ->whereNotNull('payment_received_at');
    }
}
