<?php


namespace Tests\Unit\Blog;


use App\Blog\Article;
use App\Blog\Category;
use App\Blog\Tag;
use App\Blog\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RelatedArticlesTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function selects_same_category_and_tags_first()
    {
        $match_category = factory(Category::class)->create();
        $other_category = factory(Category::class)->create();
        $match_tag = factory(Tag::class)->create();
        $other_tag = factory(Tag::class)->create();

        $subject = $this->createArticleBatch(1, $match_category, $match_tag, 'en')
        ->first();

        $related = $this->createArticleBatch(3, $match_category, $match_tag, 'en');
        $this->createArticleBatch(2, $other_category, $match_tag, 'en');
        $this->createArticleBatch(2, $match_category, $other_tag, 'en');

        $result = $subject->related('en');

        $this->assertCount(3, $result);
        $result->each(function($translation) use ($related) {
            $this->assertContains($translation->id, $related->pluck('id')->all());
        });
    }

    /**
     *@test
     */
    public function fills_with_same_category_next()
    {
        $match_category = factory(Category::class)->create();
        $other_category = factory(Category::class)->create();
        $match_tag = factory(Tag::class)->create();
        $other_tag = factory(Tag::class)->create();

        $subject = $this->createArticleBatch(1, $match_category, $match_tag, 'en')
                        ->first();

        $related = $this->createArticleBatch(2, $match_category, $match_tag, 'en');
        $same_cats = $this->createArticleBatch(2, $match_category, $other_tag, 'en');
        $this->createArticleBatch(2, $other_category, $match_tag, 'en');

        $result = $subject->related('en');

        $expected_pool = array_merge($related->pluck('id')->all(), $same_cats->pluck('id')->all());

        $this->assertCount(3, $result);

        $result->each(function($translation) use ($expected_pool) {
            $this->assertContains($translation->id, $expected_pool);
        });
    }

    /**
     *@test
     */
    public function fills_with_same_tags_next()
    {
        $match_category = factory(Category::class)->create();
        $other_category = factory(Category::class)->create();
        $match_tag = factory(Tag::class)->create();
        $other_tag = factory(Tag::class)->create();

        $subject = $this->createArticleBatch(1, $match_category, $match_tag, 'en')
                        ->first();

        $related = $this->createArticleBatch(2, $match_category, $match_tag, 'en');
        $same_tags = $this->createArticleBatch(2, $other_category, $match_tag, 'en');
        $this->createArticleBatch(2, $other_category, $other_tag, 'en');

        $result = $subject->related('en');

        $expected_pool = array_merge($related->pluck('id')->all(), $same_tags->pluck('id')->all());

        $this->assertCount(3, $result);

        $result->each(function($translation) use ($expected_pool) {
            $this->assertContains($translation->id, $expected_pool);
        });
    }

    /**
     *@test
     */
    public function fills_with_latest_live_posts()
    {
        $match_category = factory(Category::class)->create();
        $other_category = factory(Category::class)->create();
        $match_tag = factory(Tag::class)->create();
        $other_tag = factory(Tag::class)->create();

        $subject = $this->createArticleBatch(1, $match_category, $match_tag, 'en')
                        ->first();

        $related = $this->createArticleBatch(1, $match_category, $match_tag, 'en');
        $this->createArticleBatch(5, $other_category, $other_tag, 'en');

        $result = $subject->related('en');


        $this->assertCount(3, $result);
        $this->assertContains($related->first()->id, $result->pluck('id')->all());

    }

    /**
     *@test
     */
    public function does_not_include_translations_in_different_lang()
    {
        $match_category = factory(Category::class)->create();
        $other_category = factory(Category::class)->create();
        $match_tag = factory(Tag::class)->create();
        $other_tag = factory(Tag::class)->create();

        $subject = $this->createArticleBatch(1, $match_category, $match_tag, 'en')
                        ->first();

        $related = $this->createArticleBatch(2, $match_category, $match_tag, 'en');
        $related_but_wrong_lang = $this->createArticleBatch(2, $match_category, $match_tag, 'zh');
        $same_cats = $this->createArticleBatch(2, $match_category, $other_tag, 'en');
        $this->createArticleBatch(2, $other_category, $match_tag, 'en');

        $result = $subject->related('en');

        $expected_pool = array_merge($related->pluck('id')->all(), $same_cats->pluck('id')->all());

        $this->assertCount(3, $result);

        $result->each(function($translation) use ($expected_pool) {
            $this->assertContains($translation->id, $expected_pool);
        });
    }

    private function createArticleBatch($count, $category, $tag, $lang)
    {
        $articles = factory(Article::class, $count)->create();

        $articles->each(function($article) use ($lang, $category, $tag) {
            $trans = factory(Translation::class)
                ->states([$lang, 'live'])
                ->create(['article_id' => $article->id]);
            $trans->tags()->attach($tag->id);
            $article->categories()->attach($category->id);
        });

        return $articles->map(function($article) use ($lang) {
            return $article->translations()->where('language', $lang)->first();
        });
    }
}
