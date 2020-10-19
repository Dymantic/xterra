<?php


namespace Tests\Feature\Campaigns;


use App\Campaigns\Campaign;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class ClearCampaignTitleImageTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function remove_the_title_image_of_a_campaign()
    {
        Storage::fake('media', config('filesystems.disks.media'));
        $this->withoutExceptionHandling();

        $campaign = factory(Campaign::class)->create();
        $image = $campaign->setTitleImage(UploadedFile::fake()->image('testpic.png'));

        $response = $this->asAdmin()->deleteJson("/admin/campaigns/{$campaign->id}/title-image");
        $response->assertSuccessful();

        Storage::disk('media')->assertMissing(Str::after($image->getUrl(), '/media'));
        $this->assertCount(0, $campaign->fresh()->getMedia(Campaign::TITLE_IMAGE));
    }
}
