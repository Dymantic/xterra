<?php


namespace Tests\Feature\Events;


use App\Occasions\Sponsor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ClearSponsorLogoTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function clear_the_current_sponsor_logo()
    {
        $this->fakeMediaStorage();
        $this->withoutExceptionHandling();

        $sponsor = factory(Sponsor::class)->create();
        $logo = $sponsor->setLogo(UploadedFile::fake()->image("test.png"));

        $response = $this->asAdmin()->deleteJson("/admin/event-sponsors/{$sponsor->id}/image");
        $response->assertSuccessful();

        $this->assertCount(0, $sponsor->fresh()->getMedia(Sponsor::LOGO));
        $this->assertMediaStorageMissing($logo);

    }
}
