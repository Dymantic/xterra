<?php

namespace App\Http\Controllers;

use App\Media\Gallery;
use Illuminate\Http\Request;

class GalleriesController extends Controller
{
    public function show(Gallery  $gallery)
    {
        return view('front.galleries.page', [
            'gallery' => $gallery->presentForLang(app()->getLocale())
        ]);
    }
}
