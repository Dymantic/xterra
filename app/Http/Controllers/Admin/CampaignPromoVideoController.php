<?php

namespace App\Http\Controllers\Admin;

use App\Campaigns\Campaign;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmbeddableVideoRequest;
use Illuminate\Http\Request;

class CampaignPromoVideoController extends Controller
{
    public function store(EmbeddableVideoRequest $request, Campaign $campaign)
    {
        $campaign->setPromoVideo($request->video_id, $request->videoTitle());
    }

    public function destroy(Campaign $campaign)
    {
        $campaign->clearPromoVideo();
    }
}
