<?php


namespace Tests\Unit\Blog;


use App\Blog\Article;
use App\Blog\Category;
use App\Blog\Tag;
use App\Blog\Translation;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LivePostsRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function get_latest_page_of_live_posts_in_all_categories()
    {
        foreach (range(1,20) as $day) {
            factory(Translation::class)->state('published')->create([
                'language' => 'en',
                'published_on' => Carbon::yesterday()->subDays($day)
            ]);
            factory(Translation::class)->state('published')->create([
                'language' => 'zh',
                'published_on' => Carbon::yesterday()->subDays($day)
            ]);
        }

        $latest = app('live-posts')->for('en')->getPage(1, 15);

        $this->assertCount(15, $latest['posts']);
        $this->assertTrue($latest['has_next']);
        $this->assertEquals(2, $latest['next_page']);
        $this->assertFalse($latest['has_previous']);
        $this->assertEquals(1, $latest['page']);

        $this->assertEquals(
            Translation::live()->where('language', 'en')->latest('published_on')->take(15)->get()->map->toArray(),
            $latest['posts']
        );
    }

    /**
     *@test
     */
    public function get_page_of_posts_from_a_given_category()
    {
        $category = factory(Category::class)->create();
        $has_category = collect([]);
        foreach (range(1,20) as $index) {
            $article = factory(Article::class)->create();
            $article->categories()->attach($category->id);
            $trans = factory(Translation::class)->state('live')->create([
                'article_id' => $article->id,
                'language' => 'en',
                'published_on' => Carbon::yesterday()->subDays($index),
            ]);
            factory(Translation::class)->state('live')->create(['article_id' => $article->id, 'language' => 'zh']);
            $has_category->push($trans);

            factory(Article::class)->create();
        }
        $this->assertCount(20, $has_category);

        $latest = app('live-posts')->for('en')->withCategory($category)->getPage(2);

        $this->assertCount(5, $latest['posts']);
        $this->assertFalse($latest['has_next']);
        $this->assertTrue($latest['has_previous']);
        $this->assertEquals(1, $latest['previous_page']);
        $this->assertEquals(2, $latest['page']);

        $this->assertEquals(
            Translation::live()->where('language', 'en')->latest('published_on')->offset(15)->limit(15)->get()->map->toArray(),
            $latest['posts']
        );
    }

    /**
     *@test
     */
    public function get_specific_translation_for_article()
    {
        $article = factory(Article::class)->create();
        $translation = factory(Translation::class)->state('live')->create(['article_id' => $article->id, 'language' => 'en']);

        $post = app('live-posts')->for('en')->getPost($article);

        $doesnt_exist = app('live-posts')->for('zh')->getPost($article);

        $expected = $translation->toArray();
        $expected['related_posts'] = $translation->related('en')->map->toArray();

        $this->assertEquals($expected, $post);
        $this->assertNull($doesnt_exist);
    }

    /**
     *@test
     */
    public function get_null_if_translation_not_live()
    {
        $article = factory(Article::class)->create();
        $translation = factory(Translation::class)->state('draft')->create(['article_id' => $article->id, 'language' => 'en']);

        $post = app('live-posts')->for('en')->getPost($article);

        $this->assertNull($post);
    }

    /**
     *@test
     */
    public function get_posts_with_a_given_tag()
    {
        $tag = factory(Tag::class)->create();
        $tagged = collect([]);

        foreach(range(1,20) as $day) {
            $translation = factory(Translation::class)->state('live')->create([
                'language' => 'en',
                'published_on' => Carbon::yesterday()->subDays($day)
            ]);
            $translation->tags()->attach($tag->id);
            factory(Translation::class)->state('live')->create(['language' => 'en', 'published_on' => Carbon::yesterday()->subDays($day)]);
            factory(Translation::class)->state('live')->create(['language' => 'zh', 'published_on' => Carbon::yesterday()->subDays($day)]);
        }

        $latest = app('live-posts')->for('en')->taggedAs($tag)->getPage(2, 6);

        $this->assertCount(6, $latest['posts']);
        $this->assertTrue($latest['has_next']);
        $this->assertTrue($latest['has_previous']);
        $this->assertEquals(2, $latest['page']);

        $this->assertEquals(
            Translation::live()
                ->whereHas('tags', function($query) use ($tag) {
                    return $query->where('tags.id', $tag->id);
                })
                       ->where('language', 'en')
                       ->latest('published_on')
                       ->offset(6)->limit(6)->get()->map->toArray(),
            $latest['posts']
        );
    }
}
