<?php


namespace Tests\Feature\Blog;


use App\Blog\Comment;
use App\Blog\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FlagCommentTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_guest_user_can_flag_a_comment()
    {
        $this->withoutExceptionHandling();

        $translation = factory(Translation::class)->states(['live', 'en'])->create();
        $comment = factory(Comment::class)->create(['translation_id' => $translation->id]);

        $response = $this->asGuest()->postJson("/flagged-comments", [
            'flaggable_id' => $comment->id,
            'reason' => 'test reason'
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('flagged_comments', [
            'flaggable_id' => $comment->id,
            'flaggable_type' => Comment::class,
            'reason' => 'test reason'
        ]);

        $this->assertNotNull($comment->fresh()->flagged);
    }

    /**
     *@test
     */
    public function the_flaggable_id_is_required()
    {
        $response = $this->asGuest()->postJson("/flagged-comments", [
            'flaggable_id' => '',
            'reason' => 'test reason'
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('flaggable_id');
    }

    /**
     *@test
     */
    public function the_flaggable_id_must_be_for_an_existing_comment()
    {
        $this->assertNull(Comment::find(99));

        $response = $this->asGuest()->postJson("/flagged-comments", [
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
        $translation = factory(Translation::class)->states(['live', 'en'])->create();
        $comment = factory(Comment::class)->create(['translation_id' => $translation->id]);

        $response = $this->asGuest()->postJson("/flagged-comments", [
            'flaggable_id' => $comment->id,
            'reason' => ''
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('reason');
    }
}
