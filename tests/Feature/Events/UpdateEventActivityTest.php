<?php


namespace Tests\Feature\Events;


use App\Occasions\Activity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class UpdateEventActivityTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function update_an_existing_event()
    {
        $this->withoutExceptionHandling();

        $activity = factory(Activity::class)->state('activity')->create();

        $response = $this->asAdmin()->postJson("/admin/activities/{$activity->id}", [
            'name'        => ['en' => 'new name', 'zh' => 'zh new name'],
            'distance'    => ['en' => 'new distance', 'zh' => 'zh new distance'],
            'description' => ['en' => 'new description', 'zh' => 'zh new description'],
            'category'    => Activity::LIFESTYLE,
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('activities', [
            'id'          => $activity->id,
            'name'        => json_encode(['en' => 'new name', 'zh' => 'zh new name']),
            'distance'    => json_encode(['en' => 'new distance', 'zh' => 'zh new distance']),
            'description' => json_encode(['en' => 'new description', 'zh' => 'zh new description']),
            'category'    => Activity::LIFESTYLE,
            'is_race'     => false,
        ]);
    }

    /**
     * @test
     */
    public function the_name_is_required_to_be_present_in_at_least_one_translation()
    {
        $this->assertFieldIsInvalid(['name' => ['en' => '']]);
    }

    /**
     *@test
     */
    public function the_category_is_required()
    {
        $this->assertFieldIsInvalid(['category' => null]);
    }

    /**
     *@test
     */
    public function the_category_must_be_a_valid_activity()
    {
        $this->assertFieldIsInvalid(['category' => 'not-a-good-category']);
    }

    private function assertFieldIsInvalid($field)
    {
        $valid = [
            'name'        => ['en' => 'new name', 'zh' => 'zh new name'],
            'distance'    => ['en' => 'new distance', 'zh' => 'zh new distance'],
            'description' => ['en' => 'new description', 'zh' => 'zh new description'],
            'category'    => Activity::LIFESTYLE,
        ];

        $activity = factory(Activity::class)->state('activity')->create();

        $response = $this
            ->asAdmin()
            ->postJson("/admin/activities/{$activity->id}", array_merge($valid, $field));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertJsonValidationErrors(array_key_first($field));
    }
}
