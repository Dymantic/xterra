<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Shop\Promotion;
use Illuminate\Http\Request;

class
PromotionImageController extends Controller
{
    public function store(Promotion $promotion)
    {
        request()->validate([
            'image' => ['required', 'image'],
        ]);

        $image = $promotion->setImage(request('image'));

        return ['src' => $image->getUrl()];
    }

    public function destroy(Promotion $promotion)
    {
        $promotion->clearImage();
    }
}
