<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;

class LanguageController extends Controller
{
    public function switch($locale): RedirectResponse
    {
        if (in_array($locale, ['en', 'hr', 'de', 'it',])) {
            Session::put('locale', $locale);
            App::setLocale($locale);
        }

        return redirect()->back();
    }

    public static function getLocale()
    {
        return Session::get('locale', 'en'); // Default to 'en' if no locale is set
    }
}
