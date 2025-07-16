<?php

namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;

class DynamicSessionServiceProvider extends ServiceProvider
{
    public function register(): void {}


    public function boot(): void
    {
        $host = request()->getHost(); // e.g., "localhost" or "accessories.ngengroup.org"

        if (str_contains($host, 'micropack.vercel.app')) {
            Config::set('session.domain', '.micropack.vercel.app');
        } elseif (str_contains($host, 'accessories.ngengroup.org')) {
            Config::set('session.domain', '.ngengroup.org');
        } elseif (str_contains($host, 'localhost')) {
            Config::set('session.domain', null); // ✅ Let browser handle it
        } elseif (str_contains($host, '12')) {
            Config::set('session.domain', null); // ✅ Let browser handle it
        } else {
            Config::set('session.domain', null);
        }

        logger([
            'host' => $host,
            'session_domain' => config('session.domain'),
        ]);
    }
}
