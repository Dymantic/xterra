<?php

namespace App\Http\Requests;

use App\Pages\PageInfo;
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

    public function pageInfo(): PageInfo
    {
        return new PageInfo($this->all([
            'title',
            'description',
            'blurb',
            'content',
            'menu_name',
        ]));
    }
}
