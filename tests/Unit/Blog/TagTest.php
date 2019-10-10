<?php


namespace Tests\Unit\Blog;


use App\Blog\Tag;
use App\Blog\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_tag_has_a_slug()
    {
        $tag = Tag::create(['tag_name' => 'test tag']);
        $this->assertEquals('test-tag', $tag->slug);
    }

    /**
     *@test
     */
    public function tags_can_be_scoped_to_in_use()
    {
        $usedA = Tag::create(['tag_name' => 'tag one']);
        $usedB = Tag::create(['tag_name' => 'tag two']);
        $unused = Tag::create(['tag_name' => 'tag three']);

        $translationA = factory(Translation::class)->create();
        $translationB = factory(Translation::class)->create();
        $translationC = factory(Translation::class)->create();

        $translationA->tags()->attach($usedA->id);
        $translationB->tags()->attach($usedA->id);
        $translationC->tags()->attach($usedB->id);

        $used_tags = Tag::inUse()->get();

        $this->assertCount(2, $used_tags);
        $this->assertTrue($used_tags->contains($usedA));
        $this->assertTrue($used_tags->contains($usedB));
        $this->assertFalse($used_tags->contains($unused));


        $used_tags->each(function($tag) {
            $this->assertTrue($tag->translations_count > 0);
        });
    }
}