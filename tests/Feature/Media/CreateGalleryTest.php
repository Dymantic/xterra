<?php

namespace Tests\Feature\Media;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreateGalleryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function create_a_new_gallery()
    {
        $this->withoutExceptionHandling();

        $response = $this->asAdmin()->postJson("/admin/galleries", [
            'title'       => ['en' => "test title", 'zh' => "zh test title"],
            'description' => ['en' => "test description", 'zh' => "zh test description"],
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('galleries', [
            'title'       => json_encode(['en' => "test title", 'zh' => "zh test title"]),
            'description' => json_encode(['en' => "test description", 'zh' => "zh test description"]),
        ]);
    }

    /**
     *@test
     */
    public function the_title_is_required_in_at_least_one_language()
    {
        $this->assertFieldIsInvalid(['title' => ['en' => null]]);
    }

    /**
     *@test
     */
    public function the_description_must_be_an_array()
    {
        $this->assertFieldIsInvalid(['description' => 'not-an-array']);
    }

    private function assertFieldIsInvalid($field)
    {
        $valid = [
            'title'       => ['en' => "test title", 'zh' => "zh test title"],
            'description' => ['en' => "test description", 'zh' => "zh test description"],
        ];

        $response = $this
            ->asAdmin()
            ->postJson("/admin/galleries", array_merge($valid, $field));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(array_key_first($field));
    }
}
