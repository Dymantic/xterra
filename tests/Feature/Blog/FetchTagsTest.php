<?php


namespace Tests\Feature\Blog;


use App\Blog\Tag;
use App\Blog\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FetchTagsTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function fetch_all_tags_with_count()
    {
        $this->withoutExceptionHandling();

        $tagA = factory(Tag::class)->create();
        $tagB = factory(Tag::class)->create();
        $tagC = factory(Tag::class)->create();

        $translationA = factory(Translation::class)->create();
        $translationA->tags()->attach($tagA->id);
        $translationA->tags()->attach($tagB->id);

        $translationB = factory(Translation::class)->create();
        $translationB->tags()->attach($tagA->id);

        $response = $this->asAdmin()->getJson("/admin/tags");
        $response->assertStatus(200);

        $expected = [
            [
                'id' => $tagA->id,
                'slug' => $tagA->slug,
                'tag_name' => $tagA->tag_name,
                'translations_count' => 2,
            ],
            [
                'id' => $tagB->id,
                'slug' => $tagB->slug,
                'tag_name' => $tagB->tag_name,
                'translations_count' => 1,
            ],
            [
                'id' => $tagC->id,
                'slug' => $tagC->slug,
                'tag_name' => $tagC->tag_name,
                'translations_count' => 0,
            ],
        ];

        $this->assertEquals($expected, $response->decodeResponseJson());

    }


}
