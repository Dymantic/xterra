<?php


namespace Tests\Feature\Shop;


use App\Shop\Promotion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class UploadImageForPromotionTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function upload_an_image_for_a_promotion()
    {
        $this->withoutExceptionHandling();
        Storage::fake('media');

        $promotion = factory(Promotion::class)->create();

        $response = $this->asAdmin()->postJson("/admin/promotions/{$promotion->id}/image", [
            'image' => UploadedFile::fake()->image('testpic.png'),
        ]);
        $response->assertSuccessful();

        $this->assertCount(1, $promotion->fresh()->getMedia(Promotion::IMAGE));
        $image = $promotion->fresh()->getFirstMedia(Promotion::IMAGE);

        Storage::disk('media')->assertExists(Str::after($image->getUrl(), '/media'));
    }

    /**
     *@test
     */
    public function the_upload_is_required()
    {
        $this->assertUploadIsInvalid(null);
    }

    /**
     *@test
     */
    public function the_upload_must_be_a_valid_image_file()
    {
        $this->assertUploadIsInvalid('not-a-file-at-all');
        $this->assertUploadIsInvalid(UploadedFile::fake()->create('not-an-image.docx'));
    }

    private function assertUploadIsInvalid($upload)
    {
        Storage::fake('media');

        $promotion = factory(Promotion::class)->create();

        $response = $this->asAdmin()->postJson("/admin/promotions/{$promotion->id}/image", [
            'image' => $upload,
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('image');
    }
}
