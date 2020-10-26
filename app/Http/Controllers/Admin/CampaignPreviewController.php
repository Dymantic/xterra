<?php

namespace App\Http\Controllers\Admin;

use App\Campaigns\Campaign;
use App\Campaigns\CampaignPresenter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CampaignPreviewController extends Controller
{
    public function show(Campaign $campaign)
    {
        $lang = request('lang', 'en');
        app()->setLocale($lang);

        return view('front.campaigns.show', ['campaign' => CampaignPresenter::forPublic($campaign, $lang)]);
    }
}
