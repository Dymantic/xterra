<?php


namespace Tests\Feature\Events;


use App\Occasions\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DeleteCourseImageTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function remove_an_image_from_a_course_gallery()
    {
        Storage::fake('media');
        $this->withoutExceptionHandling();

        $course = factory(Course::class)->create();
        $imageA = $course->addImage(UploadedFile::fake()->image('testPicA.jpg'));
        $imageB = $course->addImage(UploadedFile::fake()->image('testPicB.jpg'));

        $response = $this->asAdmin()->deleteJson("/admin/courses/{$course->id}/images/{$imageA->id}");
        $response->assertSuccessful();

        $this->assertDatabaseMissing('media', [
            'id' => $imageA->id,
        ]);

        $this->assertDatabaseHas('media', [
            'id' => $imageB->id,
        ]);
    }
}
