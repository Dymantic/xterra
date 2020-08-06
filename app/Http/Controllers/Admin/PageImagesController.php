<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Pages\Page;
use Illuminate\Http\Request;

class PageImagesController extends Controller
{
    public function store(Page $page)
    {
        $page->saveImage(request('image'));
    }
}
