<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventCourseRequest;
use App\Occasions\Course;
use App\Occasions\Event;
use Illuminate\Http\Request;

class EventCoursesController extends Controller
{
    public function store(Event $event, EventCourseRequest $request)
    {
        $event->addCourse($request->courseInfo());
    }

    public function update(Course $course, EventCourseRequest $request)
    {
        $course->update($request->courseInfo()->toArray());
    }
}
