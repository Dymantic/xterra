<?php

namespace App\Http\Controllers\Admin;

use App\Slider\Slide;
use App\Slider\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SlidesController extends Controller
{

    public function index()
    {
        return Slider::getSetSlides();
    }

    public function store()
    {
        request()->validate([
            'position' => ['required', 'integer', 'min:1'],
            'article_id' => ['required', 'exists:articles,id'],
        ]);
        Slider::setSlide(request()->only('position', 'article_id'));
    }

    public function destroy($position)
    {
        Slider::clearSlide($position);
    }
}
