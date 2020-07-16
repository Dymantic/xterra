<?php


namespace Tests\Feature\Events;


use App\Occasions\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UploadCourseGPXFileTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function upload_gpx_file_to_course()
    {
        Storage::fake('admin_uploads');
        $this->withoutExceptionHandling();

        $course = factory(Course::class)->create();
        $file = UploadedFile::fake()->create('test_course.gpx');

        $response = $this->asAdmin()->postJson("/admin/courses/{$course->id}/gpx-file", [
            'gpx_file' => $file
        ]);
        $response->assertSuccessful();

        Storage::disk('admin_uploads')->assertExists($course->fresh()->gpx_filename);
    }

    /**
     *@test
     */
    public function the_gpx_file_is_required()
    {
        $this->assertUploadIsInvalid(['gpx_file' => null]);
    }

    /**
     *@test
     */
    public function the_upload_must_be_a_file()
    {
        $this->assertUploadIsInvalid(['gpx_file' => 'not-a-file']);
    }

    /**
     *@test
     */
    public function the_gpx_file_must_be_a_valid_gpx_file()
    {
        $this->assertUploadIsInvalid(['gpx_file' => UploadedFile::fake()->create('not-a-gpx-file.txt')]);
    }

    private function assertUploadIsInvalid($upload)
    {
        Storage::fake('admin_uploads');

        $course = factory(Course::class)->create();

        $response = $this->asAdmin()->postJson("/admin/courses/{$course->id}/gpx-file", $upload);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('gpx_file');
    }
}
