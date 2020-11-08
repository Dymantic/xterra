<?php

namespace App\Http\Controllers;

use App\Pages\Page;
use App\Pages\PagePresenter;
use Illuminate\Http\Request;

class DiscoverPagesController extends Controller
{
    public function show(Page $page)
    {
        if(!$page->is_public) {
            abort(404);
        }

        return view('front.pages.show', [
            'page' => PagePresenter::forPublic($page, app()->getLocale())
        ]);
    }
}
