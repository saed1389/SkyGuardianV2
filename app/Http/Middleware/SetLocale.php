<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Session::has('locale')) {
            $locale = Session::get('locale');
            if (in_array($locale, ['en', 'tr', 'ee'])) {
                App::setLocale($locale);
                return $next($request);
            }
        }

        if ($request->hasCookie('app_locale')) {
            $locale = $request->cookie('app_locale');
            if (in_array($locale, ['en', 'tr', 'ee'])) {
                App::setLocale($locale);
                Session::put('locale', $locale);
                return $next($request);
            }
        }

        App::setLocale('en');
        Session::put('locale', 'en');

        return $next($request);
    }
}
