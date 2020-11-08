<?php

namespace App\Http\Requests;

use App\Pages\PageMetaInfo;
use App\Rules\Translation;
use App\Rules\TranslationRequired;
use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'title' => [new TranslationRequired('en')],
            'description' => [new Translation()],
            'blurb' => [new Translation()],
            'content' => [new Translation()],
            'menu_name' => [new Translation()],
        ];
    }

    public function pageInfo(): PageMetaInfo
    {
        return new PageMetaInfo($this->all([
            'title',
            'description',
            'blurb',
            'menu_name',
        ]));
    }
}
