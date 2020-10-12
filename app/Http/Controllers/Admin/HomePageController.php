<?php

namespace App\Http\Controllers\Admin;

use App\Campaigns\CampaignPresenter;
use App\HomePage;
use App\HomePagePresenter;
use App\Http\Controllers\Controller;
use App\Occasions\EventPresenter;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function show()
    {
        return HomePagePresenter::forAdmin(HomePage::current());
    }
}
