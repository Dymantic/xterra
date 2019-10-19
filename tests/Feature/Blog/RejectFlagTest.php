<?php


namespace Tests\Feature\Blog;


use App\Blog\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RejectFlagTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function clear_a_flagged_comment()
    {
        $this->withoutExceptionHandling();

        $comment = factory(Comment::class)->create();
        $flagged = $comment->flag('test reason');

        $response = $this->asAdmin()->deleteJson("/admin/rejected-flags/{$flagged->id}");
        $response->assertStatus(200);

        $this->assertDatabaseMissing('flagged_comments', ['id' => $flagged->id]);
        $this->assertDatabaseHas('comments', ['id' => $comment->id]);
    }
}
