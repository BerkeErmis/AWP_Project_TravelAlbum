<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function switch($lang)
    {
        $available = ['tr', 'en'];
        if (in_array($lang, $available)) {
            session(['locale' => $lang]);
        }
        return redirect()->back();
    }
}
