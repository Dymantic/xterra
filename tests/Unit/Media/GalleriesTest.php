<?php


namespace Tests\Unit\Media;


use App\Media\Gallery;
use App\Media\GalleryInfo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GalleriesTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function can_create_a_new_gallery()
    {
        $galleryInfo = new GalleryInfo([
            'title' => ['en' => 'test title', 'zh' => 'zh test title'],
            'description' => ['en' => 'test description', 'zh' => 'zh test description'],
        ]);

        $gallery = Gallery::new($galleryInfo);

        $this->assertSame('test title', $gallery->title->in('en'));
        $this->assertSame('zh test title', $gallery->title->in('zh'));
        $this->assertSame('test description', $gallery->description->in('en'));
        $this->assertSame('zh test description', $gallery->description->in('zh'));
        $this->assertNotNull($gallery->slug);
    }
}
