<?php


namespace Tests\Feature\Events;


use App\Occasions\Activity;
use App\Occasions\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreateEventRaceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function create_a_race_for_an_event()
    {
        $this->withoutExceptionHandling();

        $event = factory(Event::class)->create();

        $response = $this->asAdmin()->postJson("/admin/events/{$event->id}/races", [
            'name'        => ['en' => 'test name', 'zh' => 'zh test name'],
            'distance'    => ['en' => 'test distance', 'zh' => 'zh test distance'],
            'description' => ['en' => 'test description', 'zh' => 'zh test description'],
            'category'    => Activity::RUN,
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('activities', [
            'event_id'    => $event->id,
            'name'        => json_encode(['en' => 'test name', 'zh' => 'zh test name']),
            'distance'    => json_encode(['en' => 'test distance', 'zh' => 'zh test distance']),
            'description' => json_encode(['en' => 'test description', 'zh' => 'zh test description']),
            'category'    => Activity::RUN,
            'is_race'     => true,
        ]);
    }

    /**
     * @test
     */
    public function name_cannot_be_empty_for_both_languages()
    {
        $this->assertFieldIsInvalid(['name' => ['en' => '', 'zh' => '']]);
    }

    /**
     * @test
     */
    public function the_category_is_required()
    {
        $this->assertFieldIsInvalid(['category' => null]);
    }

    /**
     * @test
     */
    public function the_category_must_be_a_valid_activity_type()
    {
        $this->assertFieldIsInvalid(['category' => 'not-a-real-category']);
    }


    private function assertFieldIsInvalid($field)
    {
        $event = factory(Event::class)->create();

        $valid = [
            'name'        => ['en' => 'test name', 'zh' => 'zh test name'],
            'distance'    => ['en' => 'test distance', 'zh' => 'zh test distance'],
            'description' => ['en' => 'test description', 'zh' => 'zh test description'],
            'category'    => Activity::RUN,
        ];

        $response = $this
            ->asAdmin()
            ->postJson("/admin/events/{$event->id}/races", array_merge($valid, $field));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertJsonValidationErrors(array_key_first($field));
    }
}
