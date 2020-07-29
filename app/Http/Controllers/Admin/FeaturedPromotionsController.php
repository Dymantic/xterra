<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Shop\Promotion;
use Illuminate\Http\Request;

class FeaturedPromotionsController extends Controller
{
    public function store()
    {
        Promotion::findOrFail(request('promotion_id'))->feature();
    }
}
