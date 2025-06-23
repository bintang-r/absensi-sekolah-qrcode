<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;

class FortifyUIServiceProvider extends ServiceProvider
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
    public function boot(): void
    {
        // for login view
        Fortify::loginView(function () {
            return view('auth.login');
        });

        // for register view
        Fortify::registerView(function () {
            return view('auth.register');
        });
    }
}
