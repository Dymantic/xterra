<?php

namespace App\Http\Controllers\Admin;

use App\Campaigns\Campaign;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CampaignTitleImageController extends Controller
{
    public function store(Campaign $campaign)
    {
        request()->validate([
            'image' => ['image'],
        ]);

        $campaign->setTitleImage(request('image'));
    }

    public function destroy(Campaign $campaign)
    {
        $campaign->clearTitleImage();
    }
}
