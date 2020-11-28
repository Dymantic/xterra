<?php

namespace App\Http\Controllers;

use App\People\Ambassador;
use App\People\AmbassadorPresenter;
use Illuminate\Http\Request;

class AmbassadorsController extends Controller
{
    public function show(Ambassador $ambassador)
    {
        return view('front.people.ambassador', [
            'ambassador' => AmbassadorPresenter::forPublic($ambassador, app()->getLocale())
        ]);
    }
}
