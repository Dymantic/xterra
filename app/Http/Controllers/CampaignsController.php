<?php

namespace App\Http\Controllers;

use App\Campaigns\Campaign;
use App\Campaigns\CampaignPresenter;
use Illuminate\Http\Request;

class CampaignsController extends Controller
{
    public function show(Campaign $campaign)
    {
        return view('front.campaigns.show', [
            'campaign' => CampaignPresenter::forPublic($campaign, app()->getLocale())
        ]);
    }
}
