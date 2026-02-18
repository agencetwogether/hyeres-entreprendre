<?php

use App\Filament\Pages\Auth\EditProfile;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Routing\Exceptions\InvalidSignatureException;
use Illuminate\Support\Facades\File;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withSchedule(function (Schedule $schedule) {
        // Queue Worker
        $schedule->exec('/usr/bin/php8.4-cli /kunden/homepages/23/d4298669514/htdocs/www/v1/artisan queue:work --stop-when-empty --timeout=120 --tries=2 >> /dev/null 2>&1')
            ->everyMinute()
            ->withoutOverlapping();

        // Backup
        $schedule->exec('/usr/bin/php8.4-cli /kunden/homepages/23/d4298669514/htdocs/www/v1/artisan backup:clean')->daily()->at('04:00');
        $schedule->exec('/usr/bin/php8.4-cli /kunden/homepages/23/d4298669514/htdocs/www/v1/artisan backup:run --only-db')->daily()->at('04:30');
        $schedule->exec('/usr/bin/php8.4-cli /kunden/homepages/23/d4298669514/htdocs/www/v1/artisan backup:monitor')->daily()->at('04:45');

        // Remove old errors logs
        $schedule->call(function () {
            $storagePath = config('error-mailer.storage_path');
            $files = File::files($storagePath);
            foreach ($files as $file) {
                if ($file->getMTime() < now()->subMonths(1)->timestamp) {
                    File::delete($file->getRealPath());
                }
            }
        })->daily()->at('01:05');

        // Delete old emails record
        $schedule->exec('/usr/bin/php8.4-cli /kunden/homepages/23/d4298669514/htdocs/www/v1/artisan model:prune --model="RickDBCN\\FilamentEmail\\Models\\Email"')->daily()->at('14:24');
    })
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (InvalidSignatureException $e) {
            return redirect(EditProfile::getUrl());
        });
    })->create();
