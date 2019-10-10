<?php


namespace Tests\Feature\Blog;


use App\Blog\Reply;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RemoveReplyTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function remove_a_reply()
    {
        $this->withoutExceptionHandling();

        $reply = factory(Reply::class)->create();

        $response = $this->asAdmin()->deleteJson("/admin/replies/{$reply->id}");
        $response->assertStatus(200);

        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }
}
