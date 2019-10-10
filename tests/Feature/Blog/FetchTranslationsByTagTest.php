<?php


namespace Tests\Feature\Blog;


use App\Blog\Tag;
use App\Blog\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FetchTranslationsByTagTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function get_tagged_translations()
    {
        $this->withoutExceptionHandling();

        $tag = factory(Tag::class)->create();

        $translationA = factory(Translation::class)->create();
        $translationB = factory(Translation::class)->create();
        $translationC = factory(Translation::class)->create();

        $translationA->tags()->attach($tag->id);
        $translationB->tags()->attach($tag->id);

        $response = $this->asAdmin()->getJson("/admin/tags/{$tag->id}/translations");
        $response->assertStatus(200);

        $fetched = $response->decodeResponseJson();

        $this->assertCount(2, $fetched);

        $this->assertContains($translationA->id, collect($fetched)->pluck('id')->all());
        $this->assertContains($translationB->id, collect($fetched)->pluck('id')->all());
        $this->assertNotContains($translationC->id, collect($fetched)->pluck('id')->all());
    }
}
