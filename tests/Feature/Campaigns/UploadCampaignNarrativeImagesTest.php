<?php


namespace Tests\Feature\Campaigns;


use App\Campaigns\Campaign;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class UploadCampaignNarrativeImagesTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function upload_a_campaign_narrative_image()
    {
        $this->withoutExceptionHandling();
        Storage::fake('media', config('filesystems.disks.media'));

        $campaign = factory(Campaign::class)->create();

        $response = $this->asAdmin()->postJson("/admin/campaigns/{$campaign->id}/narrative-images", [
            'image' => UploadedFile::fake()->image('test.png'),
        ]);
        $response->assertSuccessful();

        $this->assertCount(1, $campaign->fresh()->getMedia(Campaign::NARRATIVE_IMAGES));
        $image = $campaign->fresh()->getFirstMedia(Campaign::NARRATIVE_IMAGES);

        $this->assertEquals(1, $response->json('success'));
        $this->assertEquals(['url' => $image->getUrl('web')], $response->json('file'));

        Storage::disk('media')->assertExists(Str::after($image->getUrl(), '/media'));
    }

    /**
     *@test
     */
    public function the_image_is_required_to_be_an_accepted_image_file()
    {
        Storage::fake('media', config('filesystems.disks.media'));

        $campaign = factory(Campaign::class)->create();

        $response = $this->asAdmin()->postJson("/admin/campaigns/{$campaign->id}/narrative-images", [
            'image' => null,
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('image');

        $response = $this->asAdmin()->postJson("/admin/campaigns/{$campaign->id}/narrative-images", [
            'image' => UploadedFile::fake()->create('not-image.gpx'),
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('image');
    }
}
