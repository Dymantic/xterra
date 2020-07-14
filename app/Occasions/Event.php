<?php

namespace App\Occasions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasSchedule, HasFees, HasPrizes, HasTravelRoutes, HasAccommodation;

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
        'name' => 'array',
        'location' => 'array',
        'venue_name' => 'array',
        'venue_address' => 'array',
        'overview' => 'array',
    ];

    protected $dates = ['start', 'end'];

    public static function createWithName($name): Event
    {
        return static::create([
            'name' => [
                'en' => $name['en'] ?? '',
                'zh' => $name['zh'] ?? '',
            ],
            'slug' => Str::uuid()->toString(),
            'location' => ['en' => '', 'zh' => ''],
            'venue_name' => ['en' => '', 'zh' => ''],
            'venue_address' => ['en' => '', 'zh' => ''],
            'overview' => ['en' => '', 'zh' => ''],
        ]);
    }

    public function updateGeneralInfo(GeneralEventInfo $info)
    {
        $this->update($info->toArray());
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function addRace(ActivityInfo $info): Activity
    {
        return $this->activities()->create($info->toArray());
    }

    public function addActivity(ActivityInfo $info): Activity
    {
        return $this->activities()->create($info->toArray());
    }
}
