<?php

namespace App\Http\Requests;

use App\Campaigns\CampaignInfo;
use App\Rules\AtLeastOneTranslation;
use App\Rules\TranslationArray;
use Illuminate\Foundation\Http\FormRequest;

class CampaignRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'title' => [new AtLeastOneTranslation()],
            'intro' => [new TranslationArray()],
            'description' => [new TranslationArray()],
        ];
    }

    public function campaignInfo(): CampaignInfo
    {
        return new CampaignInfo($this->all('title', 'description', 'intro'));
    }
}
