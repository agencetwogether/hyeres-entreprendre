<?php

use App\Jobs\CheckLicence;
use App\Jobs\CheckSubscription;
use Illuminate\Support\Facades\Schedule;

Schedule::job(new CheckLicence)->daily()->at('09:10');
// Schedule::job(new CheckSubscription)->daily()->at('09:43');
