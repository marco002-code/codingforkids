<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Enforce HTTPS scheme ONLY in production and NEVER on local development (127.0.0.1 / localhost)
        $host = request()->getHost();
        if (app()->isProduction() && !in_array($host, ['127.0.0.1', 'localhost', '::1'])) {
            URL::forceScheme('https');
        }
    }
}
