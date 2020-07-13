<?php


namespace App\Occasions;


trait HasTravelRoutes
{

    public function travelRoutes()
    {
        return $this->hasMany(TravelRoute::class);
    }

    public function addTravelRoute(RouteInfo $info): TravelRoute
    {
        return $this->travelRoutes()->create($info->toArray());
    }
}
