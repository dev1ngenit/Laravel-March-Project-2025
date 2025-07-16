<?php

namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;

class DynamicSessionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $host = Request::getHost(); // returns only the hostname

        if (str_contains($host, 'micropack.vercel.app')) {
            Config::set('session.domain', '.micropack.vercel.app');
        } elseif (str_contains($host, 'ngengroup.org')) {
            Config::set('session.domain', '.ngengroup.org');
        } elseif ($host === 'localhost') {
            Config::set('session.domain', null); // Let Laravel use default for local
        } else {
            Config::set('session.domain', null); // Fallback
        }
    }
}
