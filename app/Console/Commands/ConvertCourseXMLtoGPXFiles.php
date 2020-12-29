<?php

namespace App\Console\Commands;

use App\Occasions\Course;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ConvertCourseXMLtoGPXFiles extends Command
{

    protected $signature = 'courses:convert-gpx';


    protected $description = 'Convert xml to gpx';


    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        $courses = Course::all();

        $courses->each(function(Course $course) {
            if(Storage::disk($course->gpx_disk)->exists($course->gpx_filename)) {
                $new_name = Str::replaceLast(".xml", ".gpx", $course->gpx_filename);
                Storage::disk($course->gpx_disk)->move($course->gpx_filename, $new_name);
                $course->gpx_filename = $new_name;
                $course->save();
            }

        });
        return 0;
    }
}
