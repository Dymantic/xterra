<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Pages\Page;
use Illuminate\Http\Request;

class PageImagesController extends Controller
{
    public function store(Page $page)
    {
        $image = $page->saveImage(request('image'));

        return [
            'success' => 1,
            'file' => ['url' => $image->getUrl('web')],
        ];
    }
}
