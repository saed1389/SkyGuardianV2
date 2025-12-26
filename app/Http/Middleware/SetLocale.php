<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->hasSession()) {
            if ($request->session()->has('locale')) {
                App::setLocale($request->session()->get('locale'));
            } else {
                $browserLang = $request->getPreferredLanguage(['tr', 'en']);
                $locale = in_array($browserLang, ['tr', 'en']) ? $browserLang : 'en';

                App::setLocale($locale);
                $request->session()->put('locale', $locale);
            }
        } else {
            App::setLocale(
                $request->getPreferredLanguage(['tr', 'en']) ?? 'en'
            );
        }
        return $next($request);
    }
}
