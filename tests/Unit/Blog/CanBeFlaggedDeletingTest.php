<?php


namespace Tests\Unit\Blog;


use App\Blog\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CanBeFlaggedDeletingTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function safe_deleting_flagged_comment_deletes_flag()
    {
        $translation = factory(Translation::class)->create();
        $comment = $translation->addComment([
            'author' => 'test author',
            'fb_id' => '12345678',
            'body' => 'test comment body',
        ]);

        $flag = $comment->flag('test reason');

        $comment->safeDelete();

        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
        $this->assertDatabaseMissing('flagged_comments', ['id' => $flag->id]);
    }

    /**
     *@test
     */
    public function safe_deleting_flagged_reply_deletes_the_flag()
    {
        $translation = factory(Translation::class)->create();
        $comment = $translation->addComment([
            'author' => 'test author',
            'fb_id' => '12345678',
            'body' => 'test comment body',
        ]);
        $reply = $comment->addReply([
            'author' => 'test author',
            'fb_id' => '12345678',
            'body' => 'test reply one',
        ]);

        $flag = $reply->flag('test reason');

        $reply->safeDelete();

        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
        $this->assertDatabaseMissing('flagged_comments', ['id' => $flag->id]);
    }
}
