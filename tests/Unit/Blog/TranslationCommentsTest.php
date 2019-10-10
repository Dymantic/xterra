<?php


namespace Tests\Unit\Blog;


use App\Blog\Comment;
use App\Blog\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TranslationCommentsTest extends TestCase
{
    use RefreshDatabase;

    const VALID_FB_ID = '12456789';

    /**
     *@test
     */
    public function add_comment_to_translation()
    {
        $translation = factory(Translation::class)->create();

        $comment = $translation->addComment([
            'author' => 'test author',
            'fb_id' => self::VALID_FB_ID,
            'body' => 'test comment body',
        ]);

        $this->assertInstanceOf(Comment::class, $comment);
        $this->assertEquals('test author', $comment->author);
        $this->assertEquals(self::VALID_FB_ID, $comment->fb_id);
        $this->assertEquals('test comment body', $comment->body);
    }
}