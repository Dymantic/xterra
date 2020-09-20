<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Occasions\Course;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class CourseGPXFileController extends Controller
{
    public function store(Course $course)
    {
        request()->validate([
            'gpx_file' => ['required', 'mimes:gpx,xml'],
        ]);

        $course->setGPXFile(request('gpx_file'));
    }

    public function destroy(Course $course)
    {
        $course->clearGPXFile();
    }
}
