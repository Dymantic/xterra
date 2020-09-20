<?php


namespace Tests\Unit\Media;


use App\Media\ContentCard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class ContentCardImagesTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function set_image_on_a_content_card()
    {
        Storage::fake('disk');

        $card = factory(ContentCard::class)->create();
        $upload = UploadedFile::fake()->image('test.jpg');

        $image = $card->setImage($upload);

        $this->assertTrue($card->fresh()->getFirstMedia(ContentCard::IMAGE)->is($image));
        $this->assertSame($upload->hashName(), $image->file_name);

        Storage::disk('media')->assertExists(Str::after($image->getUrl(), "/media"));

        $this->assertTrue($image->fresh()->hasGeneratedConversion('web'));
        Storage::disk('media')->assertExists(Str::after($image->getUrl('web'), "/media"));

    }

    /**
     *@test
     */
    public function can_clear_the_card_image()
    {
        Storage::fake('disk');

        $card = factory(ContentCard::class)->create();
        $image = $card->setImage(UploadedFile::fake()->image('test.jpg'));

        $card->clearImage();

        Storage::disk('media')->assertMissing(Str::after($image->getUrl(), "/media"));
        $this->assertCount(0, $card->fresh()->getMedia(ContentCard::IMAGE));
    }

    /**
     *@test
     */
    public function setting_an_image_clears_any_previous_images()
    {
        Storage::fake('disk');

        $card = factory(ContentCard::class)->create();
        $old_image = $card->setImage(UploadedFile::fake()->image('test.jpg'));
        $this->assertCount(1, $card->fresh()->getMedia(ContentCard::IMAGE));

        $new_image = $card->setImage(UploadedFile::fake()->image('new_test.jpg'));

        $this->assertCount(1, $card->fresh()->getMedia(ContentCard::IMAGE));

        Storage::disk('media')->assertMissing(Str::after($old_image->getUrl(), "/media"));
        Storage::disk('media')->assertExists(Str::after($new_image->getUrl(), "/media"));
    }
}
