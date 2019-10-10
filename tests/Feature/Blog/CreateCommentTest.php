<?php


namespace Tests\Feature\Blog;


use App\Blog\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateCommentTest extends TestCase
{
    use RefreshDatabase;

    const VALID_FB_ID = '12456789';

    /**
     *@test
     */
    public function create_a_new_comment()
    {
        $this->withoutExceptionHandling();
        $translation = factory(Translation::class)->create();
        $response = $this->asGuest()->postJson("/translations/{$translation->id}/comments", [
            'author' => 'test name',
            'fb_id' => self::VALID_FB_ID,
            'body' => 'test comment body',
        ]);
        $response->assertStatus(200);
        $this->assertEquals(
            $translation->comments->map->toArray()->all(),
            $response->decodeResponseJson()
        );

        $this->assertDatabaseHas('comments', [
            'translation_id' => $translation->id,
            'author' => 'test name',
            'fb_id' => self::VALID_FB_ID,
            'body' => 'test comment body',
        ]);
    }

    /**
     *@test
     */
    public function the_author_is_required()
    {
        $this->assertFieldIsInvalid(['author' => '']);
    }

    /**
     *@test
     */
    public function the_fb_id_is_required()
    {
        $this->assertFieldIsInvalid(['fb_id' => '']);
    }

    /**
     *@test
     */
    public function the_body_is_required()
    {
        $this->assertFieldIsInvalid(['body' => '']);
    }

    private function assertFieldIsInvalid($field)
    {
        $valid = [
            'author' => 'test name',
            'fb_id' => self::VALID_FB_ID,
            'body' => 'test comment body',
        ];
        $translation = factory(Translation::class)->create();
        $response = $this
            ->asGuest()
            ->postJson("/translations/{$translation->id}/comments", array_merge($valid, $field));
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(array_keys($field)[0]);
    }
}