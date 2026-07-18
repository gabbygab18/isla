<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Load global helpers (setting(), etc.). Also registered via composer
        // autoload "files"; require_once here keeps it working without a dump.
        require_once app_path('helpers.php');
    }

    public function boot(): void
    {
        // Force HTTPS behind a reverse proxy in production.
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}
