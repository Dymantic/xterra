<?php


namespace App\Occasions;


trait HasAccommodation
{
    public function accommodations()
    {
        return $this->hasMany(Accommodation::class);
    }

    public function addAccommodation(AccommodationInfo $info)
    {
        return $this->accommodations()->create($info->toArray());
    }
}
