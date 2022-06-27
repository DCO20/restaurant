<?php

namespace App\Providers;

use App\Models\Reservation;
use App\Observers\ReservartionObserver;
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
        Reservation::observe(ReservartionObserver::class);
    }
}
