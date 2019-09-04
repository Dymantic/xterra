<?php


namespace Tests\Unit\Blog;


use App\Blog\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class TranslationsTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function publish_a_translation()
    {
        $translation = factory(Translation::class)->state('unpublished')->create();

        $translation->publish(Carbon::today()->format('Y-m-d'));

        $translation = $translation->fresh();
        $this->assertTrue($translation->published_on->isToday());
        $this->assertTrue($translation->is_published);
    }

    /**
     *@test
     */
    public function a_previously_unpublished_translation_will_update_slug_on_update()
    {
        $translation = factory(Translation::class)->state('unpublished')->create([
            'title' => 'original title'
        ]);

        $this->assertEquals('original-title', $translation->slug);

        $translation->update(['title' => 'new title']);

        $this->assertEquals('new-title', $translation->fresh()->slug);
    }

    /**
     *@test
     */
    public function a_previously_published_translation_wont_update_slug()
    {
        $translation = factory(Translation::class)->state('published')->create([
            'title' => 'original title'
        ]);

        $this->assertEquals('original-title', $translation->slug);

        $translation->update(['title' => 'new title']);

        $this->assertEquals('original-title', $translation->fresh()->slug);
    }

    /**
     *@test
     */
    public function retracting_a_translation()
    {
        $translation = factory(Translation::class)->state('published')->create();

        $this->assertTrue($translation->is_published);
        $this->assertTrue($translation->isLive());

        $translation->retract();

        $this->assertFalse($translation->fresh()->is_published);
        $this->assertFalse($translation->fresh()->isLive());
    }

    /**
     *@test
     */
    public function translation_is_live_if_published_and_published_on_date_is_past()
    {
        $live_and_old = factory(Translation::class)->state('published')->create([
            'published_on' => Carbon::today()->subYear(),
        ]);
        $live_today = factory(Translation::class)->state('published')->create([
            'published_on' => Carbon::today(),
        ]);

        $unpublished_old = factory(Translation::class)->state('unpublished')->create([
            'first_published_on' => Carbon::today()->subYear(),
            'published_on' => Carbon::today()->subYear(),
        ]);

        $published_future = factory(Translation::class)->state('published')->create([
            'published_on' => Carbon::tomorrow(),
        ]);

        $unpublished_future = factory(Translation::class)->state('unpublished')->create([
            'published_on' => Carbon::tomorrow(),
        ]);

        $this->assertTrue($live_and_old->isLive());
        $this->assertTrue($live_today->isLive());
        $this->assertFalse($unpublished_old->isLive());
        $this->assertFalse($published_future->isLive());
        $this->assertFalse($unpublished_future->isLive());


    }
}