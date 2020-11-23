<?php

namespace App\Http\Controllers\Admin;

use App\Campaigns\Campaign;
use App\Http\Controllers\Controller;
use App\People\Coach;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CampaignCoachesController extends Controller
{
    public function store(Campaign $campaign)
    {
        request()->validate([
            'coach_id' => ['exists:coaches,id']
        ]);

        if($campaign->coaches->pluck('id')->contains(request('coach_id'))) {
            throw ValidationException::withMessages(['coach_id' => 'Coach already attached to campaign']);
        }

        $campaign->coaches()->attach(request('coach_id'));
    }

    public function destroy(Campaign $campaign, Coach $coach)
    {
        $campaign->coaches()->detach($coach->id);
    }
}
