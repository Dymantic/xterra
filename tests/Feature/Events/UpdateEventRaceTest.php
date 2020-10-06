<?php


namespace Tests\Feature\Events;


use App\Occasions\Activity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class UpdateEventRaceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function update_an_existing_race()
    {
        $this->withoutExceptionHandling();

        $race = factory(Activity::class)->state('race')->create();

        $response = $this->asAdmin()->postJson("/admin/races/{$race->id}", [
            'name'        => ['en' => 'new name', 'zh' => 'zh new name'],
            'distance'    => ['en' => 'new distance', 'zh' => 'zh new distance'],
            'category'    => Activity::SWIM,
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('activities', [
            'name'        => json_encode(['en' => 'new name', 'zh' => 'zh new name']),
            'distance'    => json_encode(['en' => 'new distance', 'zh' => 'zh new distance']),
            'category'    => Activity::SWIM,
            'is_race'     => true,
        ]);
    }

    /**
     *@test
     */
    public function the_name_requires_a_translation()
    {
        $this->assertFieldIsInvalid(['name' => ['en' => '', 'zh' => '']]);
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
    public function the_category_must_be_an_existing_activity_type()
    {
        $this->assertFieldIsInvalid(['category' => 'something-that-is-not-an-activity-type']);
    }

    private function assertFieldIsInvalid($field)
    {
        $valid = [
            'name'        => ['en' => 'new name', 'zh' => 'zh new name'],
            'distance'    => ['en' => 'new distance', 'zh' => 'zh new distance'],
            'description' => ['en' => 'new description', 'zh' => 'zh new description'],
            'category'    => Activity::SWIM,
        ];

        $race = factory(Activity::class)->state('race')->create();

        $response = $this
            ->asAdmin()
            ->postJson("/admin/races/{$race->id}", array_merge($valid, $field));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertJsonValidationErrors(array_key_first($field));
    }
}
