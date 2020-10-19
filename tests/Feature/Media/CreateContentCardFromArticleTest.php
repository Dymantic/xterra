<?php


namespace Tests\Feature\Media;


use App\Blog\Article;
use App\Blog\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CreateContentCardFromArticleTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function create_a_new_content_card_from_an_article()
    {
        Storage::fake('media', config('filesystems.disks.media'));
        $this->withoutExceptionHandling();

        $article = factory(Article::class)->create();
        $english = factory(Translation::class)->state('en')->create(['article_id' => $article->id]);
        $chinese = factory(Translation::class)->state('zh')->create(['article_id' => $article->id]);

        $response = $this->asAdmin()->postJson('admin/article-content-cards', [
            'article_id' => $article->id,
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('content_cards', [
            'category' => json_encode([
                'en' => Lang::get('content-cards.blog', [], 'en'),
                'zh' => Lang::get('content-cards.blog', [], 'zh'),
            ]),
            'title' => json_encode(['en' => $english->title, 'zh' => $chinese->title]),
            'link' => "/blog/{$article->slug}/"
        ]);
    }
}
