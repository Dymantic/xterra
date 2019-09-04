<?php


namespace Tests\Unit\Blog;


use App\Blog\Tag;
use App\Blog\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TranslationTagsTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function set_tags_on_a_translation()
    {
        $translation = factory(Translation::class)->create();
        $tag_names = ['test one', 'test two', 'test three'];
        $translation->setTags($tag_names);

        $this->assertEquals($tag_names, $translation->getTags());
    }

    /**
     *@test
     */
    public function empty_and_non_string_tags_are_ignored()
    {
        $translation = factory(Translation::class)->create();
        $tag_names = ['', 'test two', ['test three', 'test four'], 666];
        $translation->setTags($tag_names);

        $this->assertEquals(['test two'], $translation->getTags());
    }

    /**
     *@test
     */
    public function does_not_recreate_tags()
    {
        Tag::create(['tag_name' => 'test one']);
        Tag::create(['tag_name' => 'test two']);
        Tag::create(['tag_name' => 'test three']);
        $this->assertCount(3, Tag::all());

        $translation = factory(Translation::class)->create();
        $tag_names = ['test one', 'test two', 'test three'];
        $translation->setTags($tag_names);
        $this->assertEquals($tag_names, $translation->getTags());

        $this->assertCount(3, Tag::all());
    }
}