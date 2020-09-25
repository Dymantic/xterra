<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RaceCourseRequest;
use App\Occasions\Activity;
use App\Occasions\Course;
use App\Occasions\Event;
use Illuminate\Http\Request;

class RaceCoursesController extends Controller
{
    public function store(Activity $race, RaceCourseRequest $request)
    {
        $race->addCourse($request->courseInfo());
    }

    public function update(Course $course, RaceCourseRequest $request)
    {
        $course->update($request->courseInfo()->toArray());
    }

    public function delete(Course $course)
    {
        $course->delete();
    }
}
