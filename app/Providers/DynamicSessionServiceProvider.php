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
        // Detect request origin
        $origin = Request::header('Origin') ?? Request::header('Referer');
        $clientHost = parse_url($origin, PHP_URL_HOST) ?? Request::getHost();

        // Normalize
        $clientHost = strtolower($clientHost);

        // Strict ordering — check specific domains FIRST
        if ($clientHost === 'accessories.ngengroup.org') {
            Config::set('session.domain', 'accessories.ngengroup.org');
        } elseif ($clientHost === 'micropack.vercel.app') {
            Config::set('session.domain', '.micropack.vercel.app');
        } elseif ($clientHost === 'localhost') {
            Config::set('session.domain', null);
        } elseif ($clientHost === 'ngengroup.org') {
            Config::set('session.domain', 'ngengroup.org');
        } else {
            Config::set('session.domain', null);
        }
    }
}
