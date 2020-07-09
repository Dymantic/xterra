<?php


namespace Tests\Feature\Events;


use App\Occasions\Activity;
use App\Occasions\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreateEventActivityTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function create_a_new_activity_for_an_event()
    {
        $this->withoutExceptionHandling();

        $event = factory(Event::class)->create();

        $response = $this->asAdmin()->postJson("/admin/events/{$event->id}/activities", [
            'name'        => ['en' => 'text name', 'zh' => 'test name'],
            'distance'    => ['en' => 'text distance', 'zh' => 'test distance'],
            'description' => ['en' => 'text description', 'zh' => 'test description'],
            'category'    => Activity::SEMINAR,
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('activities', [
            'event_id'    => $event->id,
            'name'        => json_encode(['en' => 'text name', 'zh' => 'test name']),
            'distance'    => json_encode(['en' => 'text distance', 'zh' => 'test distance']),
            'description' => json_encode(['en' => 'text description', 'zh' => 'test description']),
            'category'    => Activity::SEMINAR,
            'is_race'     => false
        ]);
    }

    /**
     *@test
     */
    public function the_name_must_be_present_in_at_least_one_translation()
    {
        $this->assertFieldIsInvalid(['name' => ['en' => null, 'zh' => '']]);
    }

    /**
     *@test
     */
    public function the_category_is_required()
    {
        $this->assertFieldIsInvalid(['category' => 'null']);
    }

    /**
     *@test
     */
    public function the_category_should_be_a_valid_event_activity()
    {
        $this->assertFieldIsInvalid(['category' => 'not-a-real-activity']);
    }

    private function assertFieldIsInvalid($field)
    {
        $valid = [
            'name'        => ['en' => 'text name', 'zh' => 'test name'],
            'distance'    => ['en' => 'text distance', 'zh' => 'test distance'],
            'description' => ['en' => 'text description', 'zh' => 'test description'],
            'category'    => Activity::SEMINAR,
        ];

        $event = factory(Event::class)->create();

        $response = $this
            ->asAdmin()
            ->postJson("/admin/events/{$event->id}/activities", array_merge($valid, $field));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertJsonValidationErrors(array_key_first($field));
    }
}
