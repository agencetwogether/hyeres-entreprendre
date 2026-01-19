<?php

namespace App\Jobs;

use App\Models\Subscription;
use App\Notifications\SubscriptionIsAboutToExpire;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;

class CheckSubscription implements ShouldQueue
{
    use Dispatchable, Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct() {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $monthRange = 1;

        // $today = Carbon::createFromFormat('d/m/Y', '01/12/2025')->startOfDay();
        $today = Carbon::today();

        $nextDate = $today->copy()->addMonths($monthRange);

        $delta = $today->diffInDays($nextDate);

        $subscriptions = Subscription::query()
            ->with('subscriber')
            ->whereDate('ends_at', $nextDate)
            ->get();

        if ($subscriptions->isNotEmpty()) {
            foreach ($subscriptions as $subscription) {
                Notification::route(
                    'mail',
                    [
                        $subscription->subscriber->email => $subscription->subscriber->getFullName(),
                    ]
                )->notify(new SubscriptionIsAboutToExpire($subscription, $delta));
            }
        }
    }
}
