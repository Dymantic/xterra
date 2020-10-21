<?php


namespace Tests\Unit\Events;


use App\Occasions\Sponsor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class SponsorLogosTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function can_set_the_logo_for_a_sponsor()
    {
        $this->fakeMediaStorage();

        $sponsor = factory(Sponsor::class)->create();
        $upload = UploadedFile::fake()->image('logo.png');

        $logo = $sponsor->setLogo($upload);
        $sponsor->refresh();

        $this->assertTrue($sponsor->getFirstMedia(Sponsor::LOGO)->is($logo));
        $this->assertTrue($logo->fresh()->hasGeneratedConversion('thumb'));

        $this->assertMediaStorageHas($logo, ['thumb']);
    }

    /**
     *@test
     */
    public function can_clear_a_logo()
    {
        $this->fakeMediaStorage();

        $sponsor = factory(Sponsor::class)->create();
        $logo = $sponsor->setLogo(UploadedFile::fake()->image('first.png'));
        $this->assertCount(1, $sponsor->fresh()->getMedia(Sponsor::LOGO));

        $sponsor->clearLogo();

        $this->assertCount(0, $sponsor->fresh()->getMedia(Sponsor::LOGO));
        $this->assertMediaStorageMissing($logo);
    }

    /**
     *@test
     */
    public function setting_logo_clears_previous_ones()
    {
        $this->fakeMediaStorage();

        $sponsor = factory(Sponsor::class)->create();
        $old_logo = $sponsor->setLogo(UploadedFile::fake()->image('first.png'));

        $this->assertCount(1, $sponsor->fresh()->getMedia(Sponsor::LOGO));

        $new_logo = $sponsor->setLogo(UploadedFile::fake()->image('second.jpg'));

        $this->assertCount(1, $sponsor->fresh()->getMedia(Sponsor::LOGO));

        $this->assertMediaStorageMissing($old_logo);
        $this->assertMediaStorageHas($new_logo);
    }
}
