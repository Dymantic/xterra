<?php


namespace App\Occasions;


use App\People\Ambassador;
use App\People\Coach;

trait HasAttendees
{
    public function ambassadors()
    {
        return $this->morphedByMany(Ambassador::class, 'attendees');
    }

    public function coaches()
    {
        return $this->morphedByMany(Coach::class, 'attendees');
    }
}
