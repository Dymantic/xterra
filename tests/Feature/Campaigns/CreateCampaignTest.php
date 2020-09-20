<?php

namespace Tests\Feature\Campaigns;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreateCampaignTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function create_a_new_campaign()
    {
        $this->withoutExceptionHandling();

        $response = $this->asAdmin()->postJson("/admin/campaigns", [
            'title' => ['en' => 'test title', 'zh' => 'zh test title'],
            'intro' => ['en' => 'test intro', 'zh' => 'zh test intro'],
            'description' => ['en' => 'test description', 'zh' => 'zh test description'],
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('campaigns', [
            'title' => json_encode(['en' => 'test title', 'zh' => 'zh test title']),
            'intro' => json_encode(['en' => 'test intro', 'zh' => 'zh test intro']),
            'description' => json_encode(['en' => 'test description', 'zh' => 'zh test description']),
        ]);
    }

    /**
     *@test
     */
    public function the_title_is_required_in_at_least_one_translation()
    {
        $this->assertFieldIsInvalid(['title' => ['en' => null, 'zh' => '']]);
    }

    /**
     *@test
     */
    public function the_intro_must_be_in_translation_format()
    {
        $this->assertFieldIsInvalid(['intro' => 'not even an array']);
    }

    /**
     *@test
     */
    public function the_description_should_be_a_translation()
    {
        $this->assertFieldIsInvalid(['description' => []]);
    }


    private function assertFieldIsInvalid($field)
    {
        $valid = [
            'title' => ['en' => 'test title', 'zh' => 'zh test title'],
            'intro' => ['en' => 'test intro', 'zh' => 'zh test intro'],
            'description' => ['en' => 'test description', 'zh' => 'zh test description'],
        ];

        $response = $this->asAdmin()->postJson("/admin/campaigns", array_merge($valid, $field));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(array_key_first($field));
    }
}
