<?php

namespace App\Jobs;

use App\Notifications\LicenceIsAboutToExpire;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class CheckLicence implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct() {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (getLicenceInvoiceContactEmail() && getLicenceInvoiceContactName()) {

            // $now = Carbon::parse('2025-12-18')->setTimeFromTimeString('00:00:00');
            $now = Carbon::today()->setTimeFromTimeString('00:00:00');
            $endContract = getLicenceEndsAt()->setTimeFromTimeString('00:00:00');

            foreach (getDaysBefore() as $day) {
                $checkDate = $endContract->copy()->subDays($day);
                if ($checkDate->equalTo($now)) {
                    Notification::route(
                        'mail',
                        [
                            getLicenceInvoiceContactEmail() => getLicenceInvoiceContactName(),
                        ]
                    )->notify(new LicenceIsAboutToExpire($day));
                }
            }
        }
    }
}
