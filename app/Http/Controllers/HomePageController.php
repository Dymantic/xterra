<?php

namespace App\Http\Controllers;

use App\HomePage;
use App\HomePagePresenter;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function show()
    {
        $page = HomePage::current();

        return view('front.home.page', [
            'page' => HomePagePresenter::forPublic($page, app()->getLocale())
        ]);
    }
}
