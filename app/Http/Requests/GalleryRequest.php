<?php

namespace App\Http\Requests;

use App\Media\GalleryInfo;
use App\Rules\AtLeastOneTranslation;
use Illuminate\Foundation\Http\FormRequest;

class GalleryRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'title' => [new AtLeastOneTranslation()],
            'description' => ['array'],
        ];
    }

    public function galleryInfo(): GalleryInfo
    {
        return new GalleryInfo($this->all('title', 'description'));
    }
}
