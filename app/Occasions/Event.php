<?php

namespace App\Occasions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasActivities, HasSchedule, HasFees, HasPrizes, HasTravelRoutes, HasAccommodation, HasCourses;

    protected $fillable = [
        'name',
        'slug',
        'location',
        'venue_name',
        'venue_address',
        'venue_maplink',
        'start',
        'end',
        'registration_link',
        'overview'
    ];

    protected $casts = [
        'name'          => 'array',
        'location'      => 'array',
        'venue_name'    => 'array',
        'venue_address' => 'array',
        'overview'      => 'array',
        'is_public'     => 'boolean'
    ];

    protected $dates = ['start', 'end'];

    public static function createWithName($name): Event
    {
        return static::create([
            'name'          => [
                'en' => $name['en'] ?? '',
                'zh' => $name['zh'] ?? '',
            ],
            'slug'          => Str::uuid()->toString(),
            'location'      => ['en' => '', 'zh' => ''],
            'venue_name'    => ['en' => '', 'zh' => ''],
            'venue_address' => ['en' => '', 'zh' => ''],
            'overview'      => ['en' => '', 'zh' => ''],
        ]);
    }

    public function updateGeneralInfo(GeneralEventInfo $info)
    {
        $this->update($info->toArray());
    }

    public function publish()
    {
        $this->is_public = true;
        $this->save();
    }

    public function retract()
    {
        $this->is_public = false;
        $this->save();
    }
}
