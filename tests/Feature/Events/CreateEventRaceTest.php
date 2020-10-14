<?php


namespace Tests\Feature\Events;


use App\DatePresenter;
use App\Occasions\Activity;
use App\Occasions\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
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
            'name'              => ['en' => 'test name', 'zh' => 'zh test name'],
            'distance'          => ['en' => 'test distance', 'zh' => 'zh test distance'],
            'intro'             => ['en' => 'test intro', 'zh' => 'zh test intro'],
            'date'              => Carbon::today()->addMonth()->format(DatePresenter::STANDARD),
            'venue_name'        => ['en' => 'test venue_name', 'zh' => 'zh test venue_name'],
            'venue_address'     => ['en' => 'test venue_address', 'zh' => 'zh test venue_address'],
            'map_link'          => 'https://maps.test',
            'registration_link' => 'https://registration.test',
            'category'          => Activity::RUN,
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('activities', [
            'event_id'          => $event->id,
            'name'              => json_encode(['en' => 'test name', 'zh' => 'zh test name']),
            'distance'          => json_encode(['en' => 'test distance', 'zh' => 'zh test distance']),
            'intro'             => json_encode(['en' => 'test intro', 'zh' => 'zh test intro']),
            'date'              => Carbon::today()->addMonth(),
            'venue_name'        => json_encode(['en' => 'test venue_name', 'zh' => 'zh test venue_name']),
            'venue_address'     => json_encode(['en' => 'test venue_address', 'zh' => 'zh test venue_address']),
            'map_link'          => 'https://maps.test',
            'registration_link' => 'https://registration.test',
            'category'          => Activity::RUN,
            'is_race'           => true,
        ]);
    }

    /**
     * @test
     */
    public function some_empty_states_are_permitted()
    {
        $this->withoutExceptionHandling();

        $event = factory(Event::class)->create();

        $response = $this->asAdmin()->postJson("/admin/events/{$event->id}/races", [
            'name'              => ['en' => 'test name', 'zh' => 'zh test name'],
            'distance'          => ['en' => null, 'zh' => ''],
            'date'              => null,
            'venue_name'        => ['en' => '', 'zh' => ''],
            'venue_address'     => ['en' => '', 'zh' => ''],
            'map_link'          => null,
            'registration_link' => null,
            'description'       => ['en' => '', 'zh' => ''],
            'category'          => Activity::RUN,
        ]);

        $response->assertSuccessful();
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

    /**
     * @test
     */
    public function the_date_must_be_in_date_format()
    {
        $this->assertFieldIsInvalid(['date' => 'not-a-valid-date-format']);
    }

    /**
     * @test
     */
    public function the_venue_name_must_be_a_translation_array()
    {
        $this->assertFieldIsInvalid(['venue_name' => []]);
    }

    /**
     * @test
     */
    public function the_venue_address_must_be_a_translation_array()
    {
        $this->assertFieldIsInvalid(['venue_address' => 'not-even-an-array']);
    }

    /**
     * @test
     */
    public function the_map_link_must_be_a_valid_url()
    {
        $this->assertFieldIsInvalid(['map_link' => 'not-a-valid-url']);
    }

    /**
     * @test
     */
    public function the_registration_link_must_be_a_valid_url()
    {
        $this->assertFieldIsInvalid(['registration_link' => 'not-a-valid-url']);
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
