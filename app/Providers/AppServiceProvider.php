<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <-- ASEGÚRATE DE QUE ESTO ESTÉ AQUÍ

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Esto fuerza a Laravel a generar todas las imágenes y recursos con HTTPS
        URL::forceScheme('https');
    }
}
