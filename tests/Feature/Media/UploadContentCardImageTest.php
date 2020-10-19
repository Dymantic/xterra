<?php


namespace Tests\Feature\Media;


use App\Media\ContentCard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class UploadContentCardImageTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function upload_an_image_for_a_content_card()
    {
        Storage::fake('media', config('filesystems.disks.media'));
        $this->withoutExceptionHandling();

        $card = factory(ContentCard::class)->create();

        $response = $this->asAdmin()->postJson("/admin/content-cards/{$card->id}/image", [
            'image' => UploadedFile::fake()->image('test.png'),
        ]);
        $response->assertSuccessful();

        $this->assertCount(1, $card->fresh()->getMedia(ContentCard::IMAGE));
        $image = $card->fresh()->getFirstMedia(ContentCard::IMAGE);

        Storage::disk('media')->assertExists(Str::after($image->getUrl(), "/media"));
    }

    /**
     *@test
     */
    public function the_image_must_be_a_valid_image_file()
    {
        Storage::fake('media', config('filesystems.disks.media'));

        $card = factory(ContentCard::class)->create();

        $response = $this->asAdmin()->postJson("/admin/content-cards/{$card->id}/image", [
            'image' => UploadedFile::fake()->create('not-an-image.docx'),
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('image');

        $response = $this->asAdmin()->postJson("/admin/content-cards/{$card->id}/image", [
            'image' => 'not-even-a-file',
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('image');

        $response = $this->asAdmin()->postJson("/admin/content-cards/{$card->id}/image", [
            'image' => null,
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('image');
    }
}
