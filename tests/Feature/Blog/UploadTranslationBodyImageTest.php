<?php


namespace Tests\Feature\Blog;


use App\Blog\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Tests\TestsMediaAttachments;

class UploadTranslationBodyImageTest extends TestCase
{
    use RefreshDatabase, TestsMediaAttachments;

    /**
     * @test
     */
    public function upload_image_for_translation_body()
    {
        Storage::fake('media');

        $this->withoutExceptionHandling();

        $translation = factory(Translation::class)->create();
        $this->assertCount(0, $translation->getMedia(Translation::BODY_IMAGES));

        $response = $this
            ->asAdmin()
            ->postJson("/admin/translations/{$translation->id}/images", [
                'image' => UploadedFile::fake()->image('test.png'),
            ]);
        $response->assertStatus(200);


        $this->assertCount(1, $translation->fresh()->getMedia(Translation::BODY_IMAGES));
        $image = $translation->fresh()->getFirstMedia(Translation::BODY_IMAGES);

        $this->assertDiskHasMediaImage('media', $image);
    }

    /**
     *@test
     */
    public function the_image_is_required()
    {
        Storage::fake('media');

        $translation = factory(Translation::class)->create();

        $response = $this
            ->asAdmin()
            ->postJson("/admin/translations/{$translation->id}/images", [
                'image' => null,
            ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('image');
    }

    /**
     *@test
     */
    public function the_image_must_be_a_valid_image_type()
    {
        Storage::fake('media');

        $translation = factory(Translation::class)->create();

        $response = $this
            ->asAdmin()
            ->postJson("/admin/translations/{$translation->id}/images", [
                'image' => UploadedFile::fake()->create('not-image.txt'),
            ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('image');
    }
}