<?php

namespace App\Http\Controllers\Admin;

use App\Campaigns\Campaign;
use App\Http\Controllers\Controller;
use App\Shop\Promotion;
use Illuminate\Http\Request;

class CampaignPromotionController extends Controller
{
    public function update(Campaign $campaign)
    {
        $campaign->setPromotion(Promotion::findOrFail(request('promotion_id')));
    }
}
