<?php


namespace App\Occasions;


use App\UniqueKey;

trait HasActivities
{
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function addRace(ActivityInfo $info): Activity
    {
        return $this
            ->activities()
            ->create(array_merge($info->toArray(), ['slug' => UniqueKey::for('activities:slug')]));
    }

    public function addActivity(ActivityInfo $info): Activity
    {
        return $this
            ->activities()
            ->create(array_merge($info->toArray(), ['slug' => UniqueKey::for('activities:slug')]));
    }

    public function listCategories(): array
    {
        return $this
            ->activities()
            ->orderBy('date')
            ->get()
            ->map(fn (Activity $activity) => $activity->category)
            ->unique()
            ->values()->all();
    }
}
