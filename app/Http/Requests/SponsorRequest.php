<?php

namespace App\Http\Requests;

use App\Occasions\SponsorInfo;
use App\Rules\TranslationArray;
use Illuminate\Foundation\Http\FormRequest;

class SponsorRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'name' => [new TranslationArray()],
            'description' => [new TranslationArray()],
            'link' => ['url', 'nullable'],
        ];
    }

    public function sponsorInfo(): SponsorInfo
    {
        return new SponsorInfo($this->all([
            'name',
            'description',
            'link',
        ]));
    }
}
