<?php

namespace App\Http\Controllers\Admin;

use App\HomePage;
use App\Http\Controllers\Controller;
use App\Shop\Promotion;
use Illuminate\Http\Request;

class HomePageFeaturedPromotionController extends Controller
{
    public function store()
    {
        request()->validate([
            'promotion_id' => ['exists:promotions,id'],
        ]);

        HomePage::current()->featurePromotion(Promotion::find(request('promotion_id')));
    }
}
