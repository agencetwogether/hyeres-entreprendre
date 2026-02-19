<?php

namespace App\Providers;

use App\Concerns\UseColorsTrait;
// use App\Models\Subscription;
use App\Notifications\CustomFilamentResetPasswordNotification;
use App\Policies\MenuItemPolicy;
use App\Policies\MenuPolicy;
use App\Policies\PlanPolicy;
use Biostate\FilamentMenuBuilder\Models\Menu;
use Biostate\FilamentMenuBuilder\Models\MenuItem;
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
        Gate::policy(Menu::class, MenuPolicy::class);
        Gate::policy(MenuItem::class, MenuItemPolicy::class);

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
