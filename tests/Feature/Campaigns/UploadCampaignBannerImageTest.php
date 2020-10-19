<?php


namespace Tests\Feature\Campaigns;


use App\Campaigns\Campaign;
use App\Occasions\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class UploadCampaignBannerImageTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function upload_the_banner_image_of_a_campaign()
    {
        Storage::fake('media', config('filesystems.disks.media'));
        $this->withoutExceptionHandling();

        $campaign = factory(Campaign::class)->create();

        $response = $this->asAdmin()->postJson("/admin/campaigns/{$campaign->id}/banner-image", [
            'image' => UploadedFile::fake()->image('test.jpg'),
        ]);
        $response->assertSuccessful();

        $this->assertCount(1, $campaign->getMedia(Campaign::BANNER_IMAGE));
        $image = $campaign->getFirstMedia(Campaign::BANNER_IMAGE);

        Storage::disk('media')->assertExists(Str::after($image->getUrl(), "/media"));
    }

    /**
     *@test
     */
    public function the_banner_image_must_be_an_actual_image_file()
    {
        Storage::fake('media', config('filesystems.disks.media'));
        $campaign = factory(Campaign::class)->create();

        $response = $this->asAdmin()->postJson("/admin/campaigns/{$campaign->id}/banner-image", [
            'image' => null,
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('image');

        $response = $this->asAdmin()->postJson("/admin/campaigns/{$campaign->id}/banner-image", [
            'image' => UploadedFile::fake()->create('not-an-image.docx'),
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('image');

        $response = $this->asAdmin()->postJson("/admin/campaigns/{$campaign->id}/banner-image", [
            'image' => 'not-a-file',
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('image');
    }
}
