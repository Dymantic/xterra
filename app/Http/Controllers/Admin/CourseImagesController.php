<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Occasions\Course;
use Illuminate\Http\Request;

class CourseImagesController extends Controller
{
    public function store(Course $course)
    {
        request()->validate([
            'image' => ['required', 'image']
        ]);

        $course->addImage(request('image'));
    }
}
