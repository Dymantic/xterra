<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Occasions\Course;
use Illuminate\Http\Request;

class CourseImagesOrderController extends Controller
{
    public function update(Course $course)
    {
        request()->validate([
            'image_ids' => ['required', 'array'],
            'image_ids.*' => ['exists:media,id']
        ]);

        $course->setImagePositions(request('image_ids'));
    }
}
