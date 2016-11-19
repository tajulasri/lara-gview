<?php

namespace LaraGview;;

use Illuminate\Support\ServiceProvider;

class LaraGViewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
        
        $this->commands([
           LaraGview\Commands\GenerateView::class
        ]);
    }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    
    }
}
