<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
{
    public function show()
    {
        if(app()->getLocale() === 'en') {
            return view('front.policies.privacy-en');
        }
        return view('front.policies.privacy-zh');
    }
}
