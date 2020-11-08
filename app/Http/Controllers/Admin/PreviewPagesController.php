<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Pages\Page;
use App\Pages\PagePresenter;
use Illuminate\Http\Request;

class PreviewPagesController extends Controller
{
    public function show(Page $page)
    {
        $lang = request('lang', 'en');

        app()->setLocale($lang);

        return view('front.pages.show', [
            'page' => PagePresenter::forPublic($page, $lang)
        ]);
    }
}
