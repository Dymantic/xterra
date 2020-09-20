<?php

namespace App\Http\Controllers\Admin;

use App\Campaigns\Campaign;
use App\Http\Controllers\Controller;
use App\Occasions\Event;
use Illuminate\Http\Request;

class CampaignEventController extends Controller
{
    public function update(Campaign $campaign)
    {
        $campaign->setEvent(Event::findOrFail(request('event_id')));
    }
}
