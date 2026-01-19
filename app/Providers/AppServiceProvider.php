<?php

namespace App\Providers;

use App\Concerns\UseColorsTrait;
// use App\Models\Subscription;
use App\Notifications\CustomFilamentResetPasswordNotification;
use App\Policies\PlanPolicy;
use Carbon\Carbon;
use Filament\Auth\Notifications\ResetPassword as FilamentResetPassword;
use Filament\Support\Facades\FilamentColor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Laravelcm\Subscriptions\Models\Plan;

class AppServiceProvider extends ServiceProvider
{
    use UseColorsTrait;

    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Override ResetNotification with custom
        $this->app->bind(FilamentResetPassword::class, function ($app, $params) {
            return new CustomFilamentResetPasswordNotification($params['token']);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::preventLazyLoading(! app()->isProduction());

        Gate::policy(Plan::class, PlanPolicy::class);

        Carbon::setLocale(config('app.locale'));

        Password::defaults(function () {
            $rule = Password::min(8);

            return $this->app->isProduction()
                ? $rule->mixedCase()->numbers()
                : $rule;
        });

        FilamentColor::register($this->useColors());
    }
}
