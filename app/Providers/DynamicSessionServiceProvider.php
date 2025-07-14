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
        $host = Request::getHost(); // accessories.ngengroup.org or api.micropack.vercel.app

        if (str_contains($host, 'micropack.vercel.app')) {
            Config::set('session.domain', '.micropack.vercel.app');
        } elseif (str_contains($host, 'ngengroup.org')) {
            Config::set('session.domain', '.ngengroup.org');
        }elseif (str_contains($host, 'http://localhost:3000/')) {
            Config::set('session.domain', 'http://localhost:3000/');
        } else {
            // Default domain if none of the above matches
            Config::set('session.domain', null);
        }
    }
}
