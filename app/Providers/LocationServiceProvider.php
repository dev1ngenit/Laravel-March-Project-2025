<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Cache;

class LocationServiceProvider extends ServiceProvider
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
    public function boot()
    { 
        $this->app->singleton('location', function ($app) {
            $ip = Request::ip(); // Get user's IP address

            return Cache::remember("location_{$ip}", 60 * 60, function () use ($ip) {
                $response = Http::get("http://ip-api.com/json/{$ip}");

                if ($response->successful()) {
                    $data = $response->json();
                    return [
                        'city' => $data['city'] ?? 'Unknown',
                        'country' => $data['country'] ?? 'Unknown',
                    ];
                }

                return ['city' => 'Unknown', 'country' => 'Unknown'];
            });
        });

        View::composer('*', function ($view) {
            $location = app('location');
            $view->with('city', $location['city'] ?? 'Unknown');
            $view->with('country', $location['country'] ?? 'Unknown');
        });


    }
}
