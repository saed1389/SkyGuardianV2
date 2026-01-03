<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switch(Request $request)
    {
        $locale = $request->input('lang');
        $allowed = ['en', 'tr', 'ee'];

        if (!in_array($locale, $allowed)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid language'
            ]);
        }

        App::setLocale($locale);

        Session::put('locale', $locale);
        $request->session()->put('locale', $locale);

        $request->session()->save();

        $cookie = cookie('app_locale', $locale, 60 * 24 * 30); // 30 days

        return response()->json([
            'success' => true,
            'locale' => $locale,
            'message' => 'Language changed successfully'
        ])->cookie($cookie);
    }
}
