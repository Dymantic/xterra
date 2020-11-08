<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PageRequest;
use App\Pages\Page;
use Illuminate\Http\Request;

class PagesController extends Controller
{

    public function index()
    {
        return Page::latest()->get()->map->presentForAdmin()->values()->all();
    }

    public function store(PageRequest $request)
    {
        Page::new($request->pageInfo());
    }

    public function update(Page $page, PageRequest $request)
    {
        $page->update($request->pageInfo()->toArray());
    }

    public function delete(Page $page)
    {
        $page->delete();
    }
}
