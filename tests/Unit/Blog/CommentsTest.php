<?php


namespace Tests\Unit\Blog;


use App\Blog\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentsTest extends TestCase
{
    use RefreshDatabase;

    const VALID_FB_ID = '1234567890';

    /**
     *@test
     */
    public function safe_delete_a_comment()
    {
        $translation = factory(Translation::class)->create();
        $comment = $translation->addComment([
            'author' => 'test author',
            'fb_id' => self::VALID_FB_ID,
            'body' => 'test comment body',
        ]);
        $replyA = $comment->addReply([
            'author' => 'test author',
            'fb_id' => self::VALID_FB_ID,
            'body' => 'test reply one',
        ]);
        $replyB = $comment->addReply([
            'author' => 'test author',
            'fb_id' => self::VALID_FB_ID,
            'body' => 'test reply two',
        ]);

        $comment->safeDelete();

        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
        $this->assertDatabaseMissing('replies', ['id' => $replyA->id]);
        $this->assertDatabaseMissing('replies', ['id' => $replyB->id]);

    }
}
