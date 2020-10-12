<?php

namespace App\Http\Controllers\Admin;

use App\Campaigns\Campaign;
use App\Http\Controllers\Controller;
use App\Http\Requests\BannerVideoUploadRequest;
use Illuminate\Http\Request;

class CampaignBannerVideoController extends Controller
{
    public function store(BannerVideoUploadRequest  $request, Campaign $campaign)
    {
        $campaign->setBannerVideo($request->video);
    }

    public function destroy(Campaign $campaign)
    {
        $campaign->clearBannerVideo();
    }
}
