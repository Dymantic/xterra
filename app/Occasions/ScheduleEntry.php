<?php

namespace App\Occasions;

use Illuminate\Database\Eloquent\Model;

class ScheduleEntry extends Model
{
    protected $fillable = [
        'day_of_event',
        'time_of_day',
        'item',
        'location',
        'position',
    ];

    protected $casts = [
        'item' => 'array',
        'time_of_day' => 'array',
        'location' => 'array',
    ];

    public function scheduled()
    {
        return $this->morphTo();
    }
}
