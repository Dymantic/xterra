<?php

namespace App\Http\Controllers\Admin;

use App\Campaigns\Campaign;
use App\HomePage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomePageFeaturedCampaignController extends Controller
{
    public function store()
    {
        request()->validate([
            'campaign_id' => ['exists:campaigns,id'],
        ]);

        HomePage::current()->featureCampaign(Campaign::find(request('campaign_id')));
    }
}
