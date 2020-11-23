<?php

namespace App\Http\Controllers\Admin;

use App\Campaigns\Campaign;
use App\Http\Controllers\Controller;
use App\People\Ambassador;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CampaignAmbassadorsController extends Controller
{
    public function store(Campaign $campaign)
    {
        request()->validate([
            'ambassador_id' => ['exists:ambassadors,id']
        ]);

        if($campaign->ambassadors->pluck('id')->contains(request('ambassador_id'))) {
            throw ValidationException::withMessages([
                'ambassador_id' => 'Ambassador already attached to campaign'
            ]);
        }

        $campaign->ambassadors()->attach(request('ambassador_id'));
    }

    public function destroy(Campaign $campaign, Ambassador $ambassador)
    {
        $campaign->ambassadors()->detach($ambassador->id);
    }
}
