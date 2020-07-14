<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccommodationRequest;
use App\Occasions\Accommodation;
use App\Occasions\Event;
use Illuminate\Http\Request;

class EventAccommodationsController extends Controller
{
    public function store(Event $event, AccommodationRequest $request)
    {
        $event->addAccommodation($request->accommodationInfo());
    }

    public function update(Accommodation $accommodation, AccommodationRequest $request)
    {
        $accommodation->update($request->accommodationInfo()->toArray());
    }

    public function delete(Accommodation $accommodation)
    {
        $accommodation->delete();
    }
}
