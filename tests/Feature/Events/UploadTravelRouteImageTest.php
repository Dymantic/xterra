<?php


namespace Tests\Feature\Events;


use App\Occasions\TravelRoute;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class UploadTravelRouteImageTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function upload_an_image_for_a_travel_route()
    {
        Storage::fake('media');
        $this->withoutExceptionHandling();

        $travel_route = factory(TravelRoute::class)->create();

        $response = $this->asAdmin()->postJson("/admin/travel-routes/{$travel_route->id}/image", [
            'image' => UploadedFile::fake()->image('test.png')
        ]);
        $response->assertSuccessful();

        $this->assertCount(1, $travel_route->getMedia(TravelRoute::IMAGE));
        $image = $travel_route->getFirstMedia(TravelRoute::IMAGE);

        Storage::disk('media')->assertExists(Str::after($image->getUrl(), "/media"));
    }

    /**
     *@test
     */
    public function the_image_is_required_as_an_image_file()
    {
        Storage::fake('media');
        $travel_route = factory(TravelRoute::class)->create();

        $response = $this->asAdmin()->postJson("/admin/travel-routes/{$travel_route->id}/image", [
            'image' => null,
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('image');

        $response = $this->asAdmin()->postJson("/admin/travel-routes/{$travel_route->id}/image", [
            'image' => 'not-even-a-file'
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('image');

        $response = $this->asAdmin()->postJson("/admin/travel-routes/{$travel_route->id}/image", [
            'image' => UploadedFile::fake()->create('not-an-image.docx')
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('image');
    }
}
