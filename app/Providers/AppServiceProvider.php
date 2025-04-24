<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    public function map()
    {
        $this->mapApiRoutes();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Route::prefix('api')
             ->middleware('api')
             ->group(base_path('routes/api.php'));  // Menambahkan ini untuk menghubungkan routes/api.php
    }

    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace('App\Http\Controllers') // Pastikan namespace ini ada
             ->group(base_path('routes/api.php'));
    }
}
