<?php

namespace App\Http\Requests;

use App\BannerTextInfo;
use App\Rules\TranslationArray;
use Illuminate\Foundation\Http\FormRequest;

class HomePageBannerTextRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'heading' => [new TranslationArray()],
            'subheading' => [new TranslationArray()],
        ];
    }

    public function bannerTextInfo(): BannerTextInfo
    {
        return new BannerTextInfo($this->all([
            'heading', 'subheading',
        ]));
    }
}
