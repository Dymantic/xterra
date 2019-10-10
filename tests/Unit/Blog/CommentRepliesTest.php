<?php


namespace Tests\Unit\Blog;


use App\Blog\Comment;
use App\Blog\Reply;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentRepliesTest extends TestCase
{
    use RefreshDatabase;

    const VALID_FB_ID = '123456789';
    
    /**
     *@test
     */
    public function add_reply_to_comment()
    {
        $comment = factory(Comment::class)->create();

        $reply = $comment->addReply([
            'author' => 'test author',
            'fb_id' => self::VALID_FB_ID,
            'body' => 'test reply body',
        ]);

        $this->assertInstanceOf(Reply::class, $reply);
        $this->assertEquals('test author', $reply->author);
        $this->assertEquals(self::VALID_FB_ID, $reply->fb_id);
        $this->assertEquals('test reply body', $reply->body);
    }
}