<?php


namespace Tests\Unit\Blog;


use App\Blog\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Tests\TestsMediaAttachments;

class ArticleTitleImageTest extends TestCase
{
    use RefreshDatabase, TestsMediaAttachments;
    /**
     *@test
     */
    public function set_title_image_on_article()
    {
        Storage::fake('media', config('filesystems.disks.media'));

        $article = factory(Article::class)->create();

        $image = $article->setTitleImage(UploadedFile::fake()->image('testpic.png'));

        $this->assertCount(1, $article->fresh()->getMedia(Article::TITLE_IMAGES));

        $this->assertDiskHasMediaImage('media', $image);
    }

    /**
     *@test
     */
    public function it_makes_conversions()
    {
        Storage::fake('media', config('filesystems.disks.media'));
        $article = factory(Article::class)->create();
        $image = $article->setTitleImage(UploadedFile::fake()->image('testpic.png'));

        $expected_conversions = collect(['thumb', 'web', 'banner']);
        $image = $image->fresh();

        $expected_conversions->each(function($conversion) use ($image) {
            $this->assertTrue(
                $image->hasGeneratedConversion($conversion),
                "missing {$conversion} conversion"
            );
        });

        $this->assertDiskHasMediaImageConversions('media', $image, $expected_conversions);
    }

    /**
     *@test
     */
    public function article_gets_image_urls()
    {
        Storage::fake('media', config('filesystems.disks.media'));
        $with_image = factory(Article::class)->create();
        $image = $with_image->setTitleImage(UploadedFile::fake()->image('test.png'));

        $without_image = factory(Article::class)->create();

        $this->assertEquals($image->fresh()->getUrl(), $with_image->titleImage());
        $this->assertEquals($image->fresh()->getUrl('thumb'), $with_image->titleImage('thumb'));
        $this->assertEquals($image->fresh()->getUrl('web'), $with_image->titleImage('web'));
        $this->assertEquals($image->fresh()->getUrl('banner'), $with_image->titleImage('banner'));

        $this->assertEquals('/images/default.jpg', $without_image->titleImage());
        $this->assertEquals('/images/default.jpg', $without_image->titleImage('thumb'));
        $this->assertEquals('/images/default.jpg', $without_image->titleImage('web'));
        $this->assertEquals('/images/default.jpg', $without_image->titleImage('banner'));
    }

    /**
     *@test
     */
    public function only_the_latest_image_is_retained()
    {
        Storage::fake();
        $article = factory(Article::class)->create();
        $first = $article->setTitleImage(UploadedFile::fake()->image('testone.jpg'));
        $this->assertCount(1, $article->getMedia(Article::TITLE_IMAGES));

        $second = $article->setTitleImage(UploadedFile::fake()->image('testtwo.png'));
        $this->assertCount(1, $article->fresh()->getMedia(Article::TITLE_IMAGES));

        $this->assertDatabaseMissing('media', ['id' => $first->id]);

        $this->assertEquals($second->id, $article->fresh()->getFirstMedia(Article::TITLE_IMAGES)->id);

    }
}
