<?php

namespace App\Http\Controllers\Admin;

use App\Campaigns\Campaign;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CampaignNarrativeImagesController extends Controller
{
    public function store(Campaign $campaign)
    {
        request()->validate([
            'image' => ['image'],
        ]);

        $image = $campaign->setNarrativeImage(request('image'));

        return [
            'success' => 1,
            'file' => ['url' => $image->getUrl('web')],
        ];
    }
}
