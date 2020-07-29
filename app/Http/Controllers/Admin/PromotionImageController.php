<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Shop\Promotion;
use Illuminate\Http\Request;

class PromotionImageController extends Controller
{
    public function store(Promotion $promotion)
    {
        request()->validate([
            'image' => ['required', 'image'],
        ]);

        $promotion->setImage(request('image'));
    }

    public function destroy(Promotion $promotion)
    {
        $promotion->clearImage();
    }
}
