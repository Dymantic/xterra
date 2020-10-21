<?php


namespace Tests\Feature\Events;


use App\Occasions\Sponsor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UploadSponsorLogoTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function upload_an_image_for_the_sponsor_logo()
    {
        $this->withoutExceptionHandling();
        $this->fakeMediaStorage();

        $sponsor = factory(Sponsor::class)->create();

        $response = $this->asAdmin()->postJson("/admin/event-sponsors/{$sponsor->id}/image", [
            'image' => UploadedFile::fake()->image('test.png'),
        ]);
        $response->assertSuccessful();

        $this->assertCount(1, $sponsor->fresh()->getMedia(Sponsor::LOGO));
        $this->assertMediaStorageHas($sponsor->fresh()->getFirstMedia(Sponsor::LOGO));
    }

    /**
     *@test
     */
    public function the_logo_is_required_as_a_valid_image_file()
    {
        $this->fakeMediaStorage();

        $sponsor = factory(Sponsor::class)->create();

        $response = $this->asAdmin()->postJson("/admin/event-sponsors/{$sponsor->id}/image", [
            'image' => null,
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('image');

        $response = $this->asAdmin()->postJson("/admin/event-sponsors/{$sponsor->id}/image", [
            'image' => 'not-a-file',
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('image');

        $response = $this->asAdmin()->postJson("/admin/event-sponsors/{$sponsor->id}/image", [
            'image' => UploadedFile::fake()->create('not-an-image.txt'),
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('image');
    }
}
