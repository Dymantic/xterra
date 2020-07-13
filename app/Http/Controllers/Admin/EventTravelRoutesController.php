<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TravelRouteRequest;
use App\Occasions\Event;
use App\Occasions\RouteInfo;
use App\Occasions\TravelRoute;
use App\Rules\AtLeastOneTranslation;
use Illuminate\Http\Request;

class EventTravelRoutesController extends Controller
{
    public function store(Event $event, TravelRouteRequest $request)
    {
        $event->addTravelRoute($request->routeInfo());
    }

    public function update(TravelRoute $route, TravelRouteRequest $request)
    {
        $route->update($request->routeInfo()->toArray());
    }

    public function delete(TravelRoute $route)
    {
        $route->delete();
    }
}
