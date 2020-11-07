<?php

namespace App\Console\Commands;

use App\Campaigns\Campaign;
use App\Occasions\Activity;
use App\Occasions\Event;
use App\UniqueKey;
use Illuminate\Console\Command;

class ResetEventSlugs extends Command
{

    protected $signature = 'events:slugs';

    protected $description = 'Reset event slugs';


    public function handle()
    {
        Event::all()
             ->each(
                 fn(Event $event) => $event->update([
                     'slug' => UniqueKey::for('events:slug', 4)
                 ])
             );

        Campaign::all()
            ->each(
                fn(Campaign $campaign) => $campaign->update([
                    'slug' => UniqueKey::for('campaigns:slug', 4)
                ])
            );

        Activity::all()
            ->each(
                fn(Activity $activity) => $activity->update([
                    'slug' => UniqueKey::for('activities:slug', 4)
                ])
            );
    }
}
