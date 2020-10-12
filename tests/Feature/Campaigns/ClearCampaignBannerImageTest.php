<?php


namespace Tests\Feature\Campaigns;


use App\Campaigns\Campaign;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class ClearCampaignBannerImageTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function clear_existing_banner_image_for_campaign()
    {
        Storage::fake('media');
        $this->withoutExceptionHandling();

        $campaign = factory(Campaign::class)->create();
        $image = $campaign->setBannerImage(UploadedFile::fake()->image('test.png'));

        $response = $this->asAdmin()->deleteJson("/admin/campaigns/{$campaign->id}/banner-image");
        $response->assertSuccessful();

        Storage::disk('media')->assertMissing(Str::after($image->getUrl(), "/media"));
    }
}
