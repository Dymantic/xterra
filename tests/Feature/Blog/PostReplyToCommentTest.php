<?php


namespace Tests\Feature\Blog;


use App\Blog\Comment;
use App\Blog\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostReplyToCommentTest extends TestCase
{
    use RefreshDatabase;

    const VALID_FB_ID = '123456789';

    /**
     *@test
     */
    public function post_a_reply_to_a_comment()
    {
        $this->withoutExceptionHandling();

        $translation = factory(Translation::class)->create();
        $comment = factory(Comment::class)->create(['translation_id' => $translation->id]);

        $response = $this->asGuest()->postJson("/comments/{$comment->id}/replies", [
            'author' => 'test author',
            'fb_id' => self::VALID_FB_ID,
            'body' => 'test reply body'
        ]);
        $response->assertStatus(200);

        $this->assertEquals(
            $translation->fresh()->comments->map->toArray()->all(),
            $response->decodeResponseJson()
        );

        $this->assertDatabaseHas('replies', [
            'comment_id' => $comment->id,
            'author' => 'test author',
            'fb_id' => self::VALID_FB_ID,
            'body' => 'test reply body',
        ]);
    }
}