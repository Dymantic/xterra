<?php

namespace App\Http\Controllers\Admin;

use App\Campaigns\Campaign;
use App\Http\Controllers\Controller;
use App\Http\Requests\CampaignRequest;
use Illuminate\Http\Request;

class CampaignsController extends Controller
{

    public function index()
    {
        return Campaign::latest()->get()->map->presentForAdmin();
    }

    public function store(CampaignRequest $request)
    {
        Campaign::new($request->campaignInfo());
    }

    public function update(CampaignRequest $request, Campaign $campaign)
    {
        $campaign->update($request->campaignInfo()->toArray());
    }

    public function delete(Campaign $campaign)
    {
        $campaign->delete();
    }
}
