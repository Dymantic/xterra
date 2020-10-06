<?php

namespace App\Http\Controllers\Admin;

use App\Campaigns\CampaignPresenter;
use App\HomePage;
use App\Http\Controllers\Controller;
use App\Occasions\EventPresenter;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function show()
    {
        $page = HomePage::current();
        $page->load('campaign', 'event', 'promotion');

        return [
            'banner_image' => $page->bannerImage(),
            'event' => $page->event ? EventPresenter::forAdmin($page->event) : null,
            'campaign' => $page->campaign ? CampaignPresenter::forAdmin($page->campaign) : null,
            'promotion' => $page->promotion,
        ];
    }
}
