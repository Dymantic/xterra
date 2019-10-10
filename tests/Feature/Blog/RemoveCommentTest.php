<?php


namespace Tests\Feature\Blog;


use App\Blog\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RemoveCommentTest extends TestCase
{
    use RefreshDatabase;

    const VALID_FB_ID = '1234567890';

    /**
     *@test
     */
    public function remove_a_comment()
    {
        $this->withoutExceptionHandling();

        $translation = factory(Translation::class)->create();
        $comment = $translation->addComment([
            'author' => 'test author',
            'fb_id' => self::VALID_FB_ID,
            'body' => 'test comment body',
        ]);

        $response = $this->asAdmin()->deleteJson("/admin/comments/{$comment->id}");
        $response->assertStatus(200);

        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }
}
