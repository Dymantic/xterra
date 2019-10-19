<?php


namespace Tests\Feature\Blog;


use App\Blog\Reply;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FlagReplyTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function flag_a_reply()
    {
        $this->withoutExceptionHandling();

        $reply = factory(Reply::class)->create();

        $response = $this->asGuest()->postJson("/flagged-replies", [
            'flaggable_id' => $reply->id,
            'reason' => 'test reason'
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('flagged_comments', [
            'flaggable_id' => $reply->id,
            'flaggable_type' => Reply::class,
            'reason' => 'test reason'
        ]);
    }

    /**
     *@test
     */
    public function the_flaggable_id_is_required()
    {
        $response = $this->asGuest()->postJson("/flagged-replies", [
            'flaggable_id' => '',
            'reason' => 'test reason'
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('flaggable_id');
    }

    /**
     *@test
     */
    public function the_flaggable_id_must_be_for_existing_reply()
    {
        $this->assertNull(Reply::find(99));

        $response = $this->asGuest()->postJson("/flagged-replies", [
            'flaggable_id' => 99,
            'reason' => 'test reason'
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('flaggable_id');
    }

    /**
     *@test
     */
    public function the_reason_is_required()
    {
        $reply = factory(Reply::class)->create();

        $response = $this->asGuest()->postJson("/flagged-replies", [
            'flaggable_id' => $reply->id,
            'reason' => ''
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('reason');
    }
}
