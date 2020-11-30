<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\People\Ambassador;
use App\People\AmbassadorPresenter;
use Illuminate\Http\Request;

class AmbassadorPreviewController extends Controller
{
    public function show(Ambassador $ambassador)
    {
        $lang = request('lang', 'en');
        app()->setLocale($lang);

        return view('front.people.ambassador', [
            'ambassador' => AmbassadorPresenter::forPublic($ambassador, $lang)
        ]);
    }
}
