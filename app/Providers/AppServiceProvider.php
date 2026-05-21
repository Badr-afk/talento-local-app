<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Request;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Usamos la Facade Request y evitamos errores si se ejecuta desde consola
        if (!app()->runningInConsole() && str_contains(Request::getHost(), 'ngrok')) {
            URL::forceScheme('https');
        }
    }
}