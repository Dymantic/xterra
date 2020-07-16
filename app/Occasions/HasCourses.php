<?php


namespace App\Occasions;


trait HasCourses
{
    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function addCourse(CourseInfo $info): Course
    {
        return $this->courses()->create($info->toArray());
    }
}
