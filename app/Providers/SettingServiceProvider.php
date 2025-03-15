<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use App\Models\Setting;
use Exception;

class SettingServiceProvider extends ServiceProvider
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
        try {
            if (Schema::hasTable('settings')) {
                View::share('setting', Setting::first());
            } else {
                View::share('setting', null);
            }
        } catch (Exception $e) {
            View::share('setting', null);
        }
    }
}
