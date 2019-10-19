<?php


namespace Tests\Feature\Blog;


use App\Blog\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnforceFlagTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function enforce_a_flag()
    {
        $this->withoutExceptionHandling();

        $comment = factory(Comment::class)->create();
        $flagged = $comment->flag('test reason');

        $response = $this->asAdmin()->deleteJson("/admin/enforced-flags/{$flagged->id}");
        $response->assertStatus(200);

        $this->assertDatabaseMissing('flagged_comments', ['id' => $flagged->id]);
        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }
}
