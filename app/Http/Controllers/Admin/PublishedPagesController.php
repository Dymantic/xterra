<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Pages\Page;
use Illuminate\Http\Request;

class PublishedPagesController extends Controller
{
    public function store()
    {
        Page::find(request('page_id'))->publish();
    }

    public function destroy(Page $page)
    {
        $page->retract();
    }
}
