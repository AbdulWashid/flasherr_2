<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;

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
        $host = request()->getHost();
        $parts = explode('.', $host);

        // Check if host has at least two parts (e.g., 'domain.com')
        if (count($parts) >= 2) {
            // Gets the second-to-last part (e.g., 'washid' from 'washid.tech')
            $domainName = ucfirst($parts[count($parts) - 2]);
        } else {
            // A fallback for simple hosts like 'localhost'
            $domainName = ucfirst($host);
        }

        // Share the variable with all views
        View::share('domainName', $domainName);

        Paginator::useBootstrap();
    }
}
