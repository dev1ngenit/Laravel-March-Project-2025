<?php

namespace App\Providers;

use Exception;
use Carbon\Carbon;
use App\Models\Admin;
use App\Models\Brand;
use App\Models\Setting;
use App\Models\Category;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
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
        View::share('setting', null);
        View::share('categories', []);
        View::share('brands', []);
        View::share('admins', []);
        View::share('greeting','Hello');

        try {

            if (Schema::hasTable('settings')) {
                View::share('setting', Setting::first());
            }

            if (Schema::hasTable('categories')) {
                View::share('categories', Category::with('children', 'children.offers', 'offers', 'coupons')->whereNull('parent_id')->get());
            }

            if (Schema::hasTable('brands')) {
                View::share('brands', Brand::orderBy('name', 'asc')->get());
            }

            if (Schema::hasTable('admins')) {
                View::share('admins', Admin::orderBy('name', 'asc')->get());
            }
            $hour = Carbon::now('Asia/Dhaka')->format('H');
            if ($hour < 12) {
                $greeting = 'Good Morning';
            } elseif ($hour < 18) {
                $greeting = 'Good Afternoon';
            } else {
                $greeting = 'Good Evening';
            }
            View::share('greeting', $greeting);

        } catch (Exception $e) {
            // Log the exception if needed
        }
        Paginator::useBootstrap();
    }
}
