<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        if (Session::has('user_locale')) {
            $locale = Session::get('user_locale');
            App::setLocale($locale);
        } elseif ($request->hasHeader('X-User-Locale')) {
            $locale = $request->header('X-User-Locale');
            App::setLocale($locale);
            Session::put('user_locale', $locale);
        } else {
            App::setLocale(config('app.locale'));
        }
        return $next($request);
    }
}
