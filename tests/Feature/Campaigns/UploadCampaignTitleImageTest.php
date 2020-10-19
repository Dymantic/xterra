<?php


namespace Tests\Feature\Campaigns;


use App\Campaigns\Campaign;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class UploadCampaignTitleImageTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function upload_a_title_image_for_a_campaign()
    {
        Storage::fake('media', config('filesystems.disks.media'));
        $this->withoutExceptionHandling();

        $campaign = factory(Campaign::class)->create();

        $response = $this->asAdmin()->postJson("/admin/campaigns/{$campaign->id}/title-image", [
            'image' => UploadedFile::fake()->image('testpic.jpg'),
        ]);
        $response->assertSuccessful();

        $this->assertCount(1, $campaign->fresh()->getMedia(Campaign::TITLE_IMAGE));

        $image = $campaign->getFirstMedia(Campaign::TITLE_IMAGE);

        Storage::disk('media')->assertExists(Str::after($image->getUrl(), '/media'));
    }

    /**
     *@test
     */
    public function the_image_is_required_as_accepted_image_file()
    {
        Storage::fake('media', config('filesystems.disks.media'));
        $campaign = factory(Campaign::class)->create();

        $response = $this->asAdmin()->postJson("/admin/campaigns/{$campaign->id}/title-image", [
            'image' => null,
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('image');

        $response = $this->asAdmin()->postJson("/admin/campaigns/{$campaign->id}/title-image", [
            'image' => UploadedFile::fake()->create('not-image.docx'),
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('image');
    }
}
