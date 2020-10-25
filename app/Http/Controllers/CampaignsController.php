<?php

namespace App\Http\Controllers;

use App\Campaigns\Campaign;
use App\Campaigns\CampaignPresenter;
use Illuminate\Http\Request;

class CampaignsController extends Controller
{

    public function index()
    {
        return view('front.campaigns.index', [
            'campaigns' => Campaign::live()
                                   ->latest()
                                   ->get()
                                   ->map(
                                       fn ($campaign) => CampaignPresenter::forHomePage($campaign, app()->getLocale()))
        ]);
    }

    public function show(Campaign $campaign)
    {
        return view('front.campaigns.show', [
            'campaign' => CampaignPresenter::forPublic($campaign, app()->getLocale())
        ]);
    }
}
