<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SponsorRequest;
use App\Occasions\Event;
use App\Occasions\Sponsor;
use Illuminate\Http\Request;

class EventSponsorsController extends Controller
{
    public function store(SponsorRequest $request, Event $event)
    {
        $event->addSponsor($request->sponsorInfo());
    }

    public function update(SponsorRequest $request, Sponsor $sponsor)
    {
        $sponsor->update($request->sponsorInfo()->toArray());
    }

    public function delete(Sponsor $sponsor)
    {
        $sponsor->delete();
    }
}
