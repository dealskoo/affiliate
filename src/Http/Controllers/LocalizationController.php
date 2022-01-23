<?php

namespace Dealskoo\Affiliate\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LocalizationController extends Controller
{
    public function __invoke($locale)
    {
        if (array_key_exists($locale, config('affiliate.languages'))) {
            App::setLocale($locale);
            Session::put('affiliate_locale', $locale);
        }
        return back();
    }
}
