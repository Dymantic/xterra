<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Occasions\Course;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Spatie\MediaLibrary\Models\Media;

class CourseImagesController extends Controller
{
    public function store(Course $course)
    {
        request()->validate([
            'image' => ['required', 'image']
        ]);

        $course->addImage(request('image'));
    }

    public function destroy(Course $course, Media $media)
    {
        if($media->model->is($course)) {
            $media->delete();
        }
    }
}
