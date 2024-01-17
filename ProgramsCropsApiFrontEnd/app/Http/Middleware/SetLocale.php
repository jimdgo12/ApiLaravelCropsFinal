<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        // Lógica para determinar el idioma, puedes obtenerlo de la sesión, del navegador, etc.
        $locale = 'es';  // Por ejemplo, configurado a español

        // Establecer el idioma de la aplicación
        App::setLocale($locale);

        return $next($request);
    }
}
