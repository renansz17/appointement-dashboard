<?php

namespace App\Providers;

use App\Repositories\AppointmentRepository;
use App\Services\AppointmentService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->singleton(\App\Repositories\AppointmentRepository::class, function ($app) {
            return new \App\Repositories\AppointmentRepository();
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
