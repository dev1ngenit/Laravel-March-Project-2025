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
        // Fallback to host, but try reading Origin or Referer
        $origin = Request::header('Origin') ?? Request::header('Referer');
        $host = parse_url($origin, PHP_URL_HOST); // e.g., localhost, accessories.ngengroup.org

        if (str_contains($host, 'micropack.vercel.app')) {
            Config::set('session.domain', 'micropack.vercel.app');
        } elseif (str_contains($host, 'ngengroup.org')) {
            Config::set('session.domain', 'accessories.ngengroup.org');
        } elseif ($host === 'localhost') {
            Config::set('session.domain', null); // allow default behavior for local dev
        } else {
            Config::set('session.domain', null); // fallback
        }
    }
}
