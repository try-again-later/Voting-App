<?php

namespace App\Providers;

use App\Models\Category;
use App\View\Composers\CategoriesComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(['livewire.ideas-list', 'livewire.create-idea'], CategoriesComposer::class);
    }
}
