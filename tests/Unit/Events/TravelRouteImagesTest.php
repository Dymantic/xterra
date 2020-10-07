<?php


namespace Tests\Unit\Events;


use App\Occasions\TravelRoute;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class TravelRouteImagesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function set_image_for_route()
    {
        Storage::fake('media');

        $route = factory(TravelRoute::class)->create();
        $upload = UploadedFile::fake()->image('test.png');

        $image = $route->setImage($upload);

        $this->assertStringContainsString($upload->hashName(), $image->file_name);
        $this->assertTrue($route->getFirstMedia(TravelRoute::IMAGE)->is($image));
        $this->assertTrue($image->fresh()->hasGeneratedConversion('web'));

        Storage::disk('media')->assertExists(Str::after($image->getUrl(), "/media"));
        Storage::disk('media')->assertExists(Str::after($image->getUrl('web'), "/media"));

    }

    /**
     * @test
     */
    public function can_clear_the_image()
    {
        Storage::fake('media');

        $route = factory(TravelRoute::class)->create();
        $image = $route->setImage(UploadedFile::fake()->image('test.png'));

        $route->clearImage();

        $this->assertCount(0, $route->fresh()->getMedia(TravelRoute::IMAGE));

        Storage::disk('media')->assertMissing(Str::after($image->getUrl(), "/media"));
    }

    /**
     * @test
     */
    public function setting_image_clears_previous_ones()
    {
        Storage::fake('media');

        $route = factory(TravelRoute::class)->create();
        $old_image = $route->setImage(UploadedFile::fake()->image('test.png'));
        $this->assertCount(1, $route->fresh()->getMedia(TravelRoute::IMAGE));

        $new_image = $route->setImage(UploadedFile::fake()->image('test2.png'));
        $this->assertCount(1, $route->fresh()->getMedia(TravelRoute::IMAGE));

        Storage::disk('media')->assertMissing(Str::after($old_image->getUrl(), "/media"));
        Storage::disk('media')->assertExists(Str::after($new_image->getUrl(), "/media"));
    }
}
