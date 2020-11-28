<?php


namespace App\People;


use App\Occasions\Event;

trait AttendsEvents
{
    public function events()
    {
        return $this->morphToMany(Event::class, 'attendees');
    }
}
