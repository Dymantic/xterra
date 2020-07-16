<?php


namespace Tests\Feature\Events;


use App\Occasions\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RemoveCourseGPXFileTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function remove_the_gpx_file_from_a_course()
    {
        Storage::fake('admin_uploads');
        $this->withoutExceptionHandling();

        $course = factory(Course::class)->create();
        $course->setGPXFile(UploadedFile::fake()->create('test_gpx.gpx'));
        $filepath = $course->gpx_filename;

        $response = $this->asAdmin()->deleteJson("/admin/courses/{$course->id}/gpx-file");
        $response->assertSuccessful();

        Storage::disk('admin_uploads')->assertMissing($filepath);

        $this->assertDatabaseHas('courses', [
            'id' => $course->id,
            'gpx_filename' => null,
            'gpx_disk' => null,
        ]);
    }
}
