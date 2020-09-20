<?php


namespace Tests\Feature\Campaigns;


use App\Campaigns\Campaign;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class UpdateCampaignTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function update_an_existing_campaign()
    {
        $this->withoutExceptionHandling();

        $campaign = factory(Campaign::class)->create();

        $response = $this->asAdmin()->postJson("/admin/campaigns/{$campaign->id}", [
            'title'       => ['en' => 'new title', 'zh' => 'zh new title'],
            'intro'       => ['en' => 'new intro', 'zh' => 'zh new intro'],
            'description' => ['en' => 'new description', 'zh' => 'zh new description'],
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('campaigns', [
            'title'       => json_encode(['en' => 'new title', 'zh' => 'zh new title']),
            'intro'       => json_encode(['en' => 'new intro', 'zh' => 'zh new intro']),
            'description' => json_encode(['en' => 'new description', 'zh' => 'zh new description']),
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
        $campaign = factory(Campaign::class)->create();

        $valid = [
            'title'       => ['en' => 'new title', 'zh' => 'zh new title'],
            'intro'       => ['en' => 'new intro', 'zh' => 'zh new intro'],
            'description' => ['en' => 'new description', 'zh' => 'zh new description'],
        ];

        $response = $this
            ->asAdmin()
            ->postJson("/admin/campaigns/{$campaign->id}", array_merge($valid, $field));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(array_key_first($field));
    }
}
