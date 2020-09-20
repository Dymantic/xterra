<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Media\ContentCard;
use App\Shop\Promotion;
use Illuminate\Http\Request;

class PromotionContentCardsController extends Controller
{
    public function store()
    {
        $promo = Promotion::findOrFail(request('promotion_id'));

        ContentCard::fromExistingContent($promo);
    }
}
