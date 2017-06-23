<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\Blade;
use App\Helpers\Validation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        new Blade();
        new Validation();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
