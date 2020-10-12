<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BannerVideoUploadRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'video' => [
                'file',
                'mimetypes:video/x-ms-asf,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi'
            ],
        ];
    }
}
