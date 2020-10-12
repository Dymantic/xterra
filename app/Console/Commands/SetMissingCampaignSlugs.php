<?php

namespace App\Console\Commands;

use App\Campaigns\Campaign;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class SetMissingCampaignSlugs extends Command
{

    protected $signature = 'campaigns:slugify';


    protected $description = 'set slugs if missing on campaign';


    public function handle()
    {
        Campaign::whereNull('slug')
                ->get()
                ->each(fn (Campaign $campaign) => $campaign->update(['slug' => Str::random(6)]));
    }
}
