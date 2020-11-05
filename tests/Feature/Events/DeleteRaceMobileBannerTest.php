<?php


namespace Tests\Feature\Events;


use App\Occasions\Activity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class DeleteRaceMobileBannerTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function can_delete_an_existing_mobile_banner_for_a_race()
    {
        $this->withoutExceptionHandling();
        $this->fakeMediaStorage();

        $race = factory(Activity::class)->create();
        $image = $race->setMobileBanner(UploadedFile::fake()->image('test.png'));

        $response = $this->asAdmin()->deleteJson("/admin/races/{$race->id}/mobile-banner");
        $response->assertSuccessful();

        $this->assertMediaStorageMissing($image);
    }
}
