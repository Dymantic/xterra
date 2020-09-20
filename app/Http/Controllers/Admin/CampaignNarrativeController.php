<?php

namespace App\Http\Controllers\Admin;

use App\Campaigns\Campaign;
use App\Http\Controllers\Controller;
use App\Rules\TranslationArray;
use App\Translation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CampaignNarrativeController extends Controller
{
    public function update(Campaign $campaign)
    {
        request()->validate([
            'narrative.lang' => ['required', Rule::in(['en', 'zh'])],
        ]);

        $campaign->updateNarrative(request('narrative.content'), request('narrative.lang'));
    }
}
