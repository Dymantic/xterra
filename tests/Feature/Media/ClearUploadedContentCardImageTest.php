<?php


namespace Tests\Feature\Media;


use App\Media\ContentCard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class ClearUploadedContentCardImageTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function delete_the_uploaded_image_for_a_content_card()
    {
        Storage::fake('disk');
        $this->withoutExceptionHandling();

        $card = factory(ContentCard::class)->create();
        $image = $card->setImage(UploadedFile::fake()->image('test.jpg'));

        $response = $this->asAdmin()->deleteJson("/admin/content-cards/{$card->id}/image");
        $response->assertSuccessful();

        $this->assertCount(0, $card->fresh()->getMedia(ContentCard::IMAGE));

        Storage::disk('media')->assertMissing(Str::after($image->getUrl(), "/media"));

    }
}
