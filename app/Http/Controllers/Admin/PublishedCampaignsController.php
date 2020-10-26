<?php

namespace App\Http\Controllers\Admin;

use App\Campaigns\Campaign;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PublishedCampaignsController extends Controller
{
    public function store()
    {
        Campaign::findOrFail(request('campaign_id'))->publish();
    }

    public function destroy(Campaign $campaign)
    {
        $campaign->retract();
    }
}
