<?php


namespace Tests\Feature\Events;


use App\Occasions\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Tests\TestCase;

class SetCourseImagePositionsTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function set_the_image_positions_for_course_images()
    {
        Storage::fake('media', config('filesystems.disks.media'));
        $this->withoutExceptionHandling();

        $course = factory(Course::class)->create();
        $imageA = $course->addImage(UploadedFile::fake()->image('testA.jpg'));
        $imageB = $course->addImage(UploadedFile::fake()->image('testB.jpg'));
        $imageC = $course->addImage(UploadedFile::fake()->image('testC.jpg'));

        $response = $this->asAdmin()->postJson("/admin/courses/{$course->id}/images-order", [
            'image_ids' => [$imageB->id, $imageA->id, $imageC->id]
        ]);
        $response->assertSuccessful();

        $this->assertSame(0, $imageB->fresh()->getCustomProperty('position'));
        $this->assertSame(1, $imageA->fresh()->getCustomProperty('position'));
        $this->assertSame(2, $imageC->fresh()->getCustomProperty('position'));
    }

    /**
     *@test
     */
    public function the_image_ids_are_required()
    {
        $this->assertImageIdsInvalid(null);
    }

    /**
     *@test
     */
    public function the_image_ids_must_be_an_array()
    {
        $this->assertImageIdsInvalid('not-an-array');
    }

    /**
     *@test
     */
    public function each_image_id_must_exist_in_the_media_table()
    {
        $this->assertNull(Media::find(99));

        $this->assertImageIdsInvalid([99], 'image_ids.0');
    }

    private function assertImageIdsInvalid($image_ids, $error_key = 'image_ids')
    {
        Storage::fake('media', config('filesystems.disks.media'));

        $course = factory(Course::class)->create();

        $response = $this->asAdmin()->postJson("/admin/courses/{$course->id}/images-order", [
            'image_ids' => $image_ids
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors($error_key);
    }
}
