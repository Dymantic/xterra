<?php


namespace Tests\Unit\Blog;


use App\Blog\Article;
use App\Blog\Translation;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Tests\TestCase;

class ArticlesTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function make_article_with_translation()
    {
        $author = factory(User::class)->create(['name' => 'test author']);
        $article = Article::makeWithTranslation('en', 'test title', $author);

        $this->assertInstanceOf(Article::class, $article);
        $this->assertEquals(Carbon::today()->format('Y-m-d'), $article->slug);
        $this->assertCount(1, $article->translations);

        $translation = $article->translations()->first();
        $this->assertInstanceOf(Translation::class, $translation);
        $this->assertEquals('en', $translation->language);
        $this->assertEquals('test title', $translation->title);
        $this->assertEquals('test-title', $translation->slug);
        $this->assertEquals('test author', $translation->author_name);
    }

    /**
     *@test
     */
    public function articles_made_on_same_day_have_unique_slugs()
    {
        $author = factory(User::class)->create(['name' => 'test author']);
        $articleA = Article::makeWithTranslation('en', 'one title', $author);
        $articleB = Article::makeWithTranslation('en', 'another title', $author);

        $this->assertNotEquals($articleA->slug, $articleB->slug);
    }

    /**
     *@test
     */
    public function article_can_be_queried_for_live_translations()
    {
        $both = factory(Article::class)->create();
        factory(Translation::class)->states(['live', 'en'])->create(['article_id' => $both->id]);
        factory(Translation::class)->states(['live', 'zh'])->create(['article_id' => $both->id]);

        $en_only = factory(Article::class)->create();
        factory(Translation::class)->states(['live', 'en'])->create(['article_id' => $en_only->id]);

        $zh_only = factory(Article::class)->create();
        factory(Translation::class)->states(['live', 'zh'])->create(['article_id' => $zh_only->id]);

        $none = factory(Article::class)->create();
        factory(Translation::class)->states(['draft', 'en'])->create(['article_id' => $none->id]);
        factory(Translation::class)->states(['scheduled', 'zh'])->create(['article_id' => $none->id]);


        $this->assertEquals(collect(['en', 'zh']), $both->liveTranslations());
        $this->assertEquals(collect(['en']), $en_only->liveTranslations());
        $this->assertEquals(collect(['zh']), $zh_only->liveTranslations());
        $this->assertEquals(collect([]), $none->liveTranslations());
    }

    /**
     *@test
     */
    public function a_new_article_will_have_a_uuid_as_a_preview_key()
    {
        $author = factory(User::class)->create(['name' => 'test author']);
        $article = Article::makeWithTranslation('en', 'one title', $author);

        $this->assertTrue(Str::isUuid($article->fresh()->preview_key));
    }
}
