<?php

namespace App\Http\Requests;

use App\Occasions\CourseInfo;
use App\Rules\AtLeastOneTranslation;
use Illuminate\Foundation\Http\FormRequest;

class RaceCourseRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'name'        => [new AtLeastOneTranslation()],
            'distance'    => [new AtLeastOneTranslation()],
            'description' => [new AtLeastOneTranslation()],
        ];
    }

    public function courseInfo(): CourseInfo
    {
        return new CourseInfo($this->all([
            'name',
            'distance',
            'description',
        ]));
    }


}
