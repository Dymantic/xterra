<?php


namespace Tests\Feature\Shop;


use App\Shop\Promotion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class ClearPromotionImageTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function clear_an_uploaded_promotion_image()
    {
        $this->withoutExceptionHandling();
        Storage::fake('media');

        $promotion = factory(Promotion::class)->create();
        $image = $promotion->setImage(UploadedFile::fake()->image('testpic.png'));

        $response = $this->asAdmin()->deleteJson("/admin/promotions/{$promotion->id}/image");
        $response->assertSuccessful();

        $this->assertCount(0, $promotion->fresh()->getMedia(Promotion::IMAGE));

        Storage::disk('media')->assertMissing(Str::after($image->getUrl(), '/media'));
        $this->assertDatabaseMissing('media', ['id' => $image->id]);
    }
}
