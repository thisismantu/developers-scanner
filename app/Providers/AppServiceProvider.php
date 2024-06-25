<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Service\ApiService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('apiService',function($app){

            return new ApiService();
        });
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}