<?php

namespace App\Providers;

use App\Services\CategoriesService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(CategoriesService::class, function ($app) {
            return new CategoriesService;
        });

        Blade::if('admin', function () {
            return Auth::check() && Auth::user()->isAdmin();
        });
    }
}
