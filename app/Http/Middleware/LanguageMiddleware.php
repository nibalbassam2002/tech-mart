<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class LanguageMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Session::has('app_locale') && in_array(Session::get('app_locale'), config('app.available_locales'))) {
            App::setLocale(Session::get('app_locale'));
        } else {
            // If no session is set, use the default locale
            App::setLocale(config('app.locale'));
        }

        return $next($request);
    }
}