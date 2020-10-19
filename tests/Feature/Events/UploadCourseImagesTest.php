<?php


namespace Tests\Feature\Events;


use App\Occasions\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UploadCourseImagesTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function upload_image_to_course()
    {
        Storage::fake('media', config('filesystems.disks.media'));
        $this->withoutExceptionHandling();

        $course = factory(Course::class)->create();

        $response = $this->asAdmin()->postJson("/admin/courses/{$course->id}/images", [
            'image' => UploadedFile::fake()->image('testpic.png'),
        ]);
        $response->assertSuccessful();

        $this->assertCount(1, $course->fresh()->getMedia(Course::IMAGES));
    }

    /**
     *@test
     */
    public function the_image_is_required()
    {
        $this->assertUploadIsInvalid(['image' => null]);
    }

    /**
     *@test
     */
    public function image_must_be_a_valid_image_file()
    {
        $this->assertUploadIsInvalid(['image' => UploadedFile::fake()->create('not-image.txt')]);
    }

    private function assertUploadIsInvalid($upload)
    {
        Storage::fake('media', config('filesystems.disks.media'));
        $course = factory(Course::class)->create();

        $response = $this->asAdmin()->postJson("/admin/courses/{$course->id}/images", $upload);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('image');
    }
}
