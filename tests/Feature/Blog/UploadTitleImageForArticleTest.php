<?php


namespace Tests\Feature\Blog;


use App\Blog\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Tests\TestsMediaAttachments;

class UploadTitleImageForArticleTest extends TestCase
{
    use RefreshDatabase, TestsMediaAttachments;

    /**
     *@test
     */
    public function upload_a_title_image_for_article()
    {
        Storage::fake('media');

        $this->withoutExceptionHandling();

        $article = factory(Article::class)->create();
        $this->assertCount(0, $article->fresh()->getMedia(Article::TITLE_IMAGES));

        $response = $this->asAdmin()->postJson("/admin/articles/{$article->id}/title-image", [
            'image' => UploadedFile::fake()->image('testpic.png'),
        ]);
        $response->assertStatus(200);

        $this->assertCount(1, $article->fresh()->getMedia(Article::TITLE_IMAGES));
        $title_image = $article->fresh()->getFirstMedia(Article::TITLE_IMAGES);

        $this->assertDiskHasMediaImage('media', $title_image);

    }

    /**
     *@test
     */
    public function the_image_is_required()
    {
        Storage::fake('media');

        $article = factory(Article::class)->create();

        $response = $this->asAdmin()->postJson("/admin/articles/{$article->id}/title-image", [
            'image' => '',
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('image');
    }

    /**
     *@test
     */
    public function image_must_be_a_valid_image_file()
    {
        Storage::fake('media');

        $article = factory(Article::class)->create();

        $attemps = collect([
            UploadedFile::fake()->create('not-an-image.txt'),
            'just-a-string'
        ]);

        $attemps->each(function($attempt) use ($article) {
            $response = $this->asAdmin()->postJson("/admin/articles/{$article->id}/title-image", [
                'image' => $attempt,
            ]);
            $response->assertStatus(422);
            $response->assertJsonValidationErrors('image');
        });
    }
}