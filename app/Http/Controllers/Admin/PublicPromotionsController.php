<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Shop\Promotion;
use Illuminate\Http\Request;

class PublicPromotionsController extends Controller
{
    public function store()
    {
        Promotion::findOrFail(request('promotion_id'))->publish();
    }

    public function destroy(Promotion $promotion)
    {
        $promotion->retract();
    }
}
