<?php


namespace Tests\Feature\Events;


use App\DatePresenter;
use App\Occasions\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class UpdateGeneralEventInfoTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function update_general_event_info()
    {
        $this->withoutExceptionHandling();

        $event = factory(Event::class)->state('empty')->create();

        $info = [
            'name' => ['en' => 'new test name', 'zh' => 'new zh test name'],
            'location' => ['en' => 'test location', 'zh' => 'zh test location'],
            'venue_name' => ['en' => 'test venue_name', 'zh' => 'zh test venue_name'],
            'venue_address' => ['en' => 'test venue_address', 'zh' => 'zh test venue_address'],
            'venue_maplink' => 'https://test.test/map',
            'start' => Carbon::today()->addMonth()->format(DatePresenter::STANDARD),
            'end' => Carbon::today()->addMonth()->addDay()->format(DatePresenter::STANDARD),
            'registration_link' => 'https://test.test/registration',
        ];

        $response = $this->asAdmin()->postJson("/admin/events/{$event->id}/general-info", $info);
        $response->assertSuccessful();

        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'name' => json_encode(['en' => 'new test name', 'zh' => 'new zh test name']),
            'location' => json_encode(['en' => 'test location', 'zh' => 'zh test location']),
            'venue_name' => json_encode(['en' => 'test venue_name', 'zh' => 'zh test venue_name']),
            'venue_address' => json_encode(['en' => 'test venue_address', 'zh' => 'zh test venue_address']),
            'venue_maplink' => 'https://test.test/map',
            'start' => Carbon::today()->addMonth()->startOfDay(),
            'end' => Carbon::today()->addMonth()->addDay()->endOfDay(),
            'registration_link' => 'https://test.test/registration',
        ]);
    }

    /**
     *@test
     */
    public function all_non_name_fields_are_actually_optional()
    {

        $event = factory(Event::class)->state('empty')->create();

        $info = [
            'name' => ['en' => 'new test name', 'zh' => 'new zh test name'],
            'location' => null,
            'venue_name' => null,
            'venue_address' => null,
            'venue_maplink' => null,
            'start' => null,
            'end' => null,
            'registration_link' => null,
        ];

        $response = $this->asAdmin()->postJson("/admin/events/{$event->id}/general-info", $info);
        $response->assertSuccessful();

        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'name' => json_encode(['en' => 'new test name', 'zh' => 'new zh test name']),
            'location' => json_encode(['en' => '', 'zh' => '']),
            'venue_name' => json_encode(['en' => '', 'zh' => '']),
            'venue_address' => json_encode(['en' => '', 'zh' => '']),
            'venue_maplink' => null,
            'start' => null,
            'end' => null,
            'registration_link' => null,
        ]);
    }

    /**
     *@test
     */
    public function the_start_and_end_dates_can_be_the_same()
    {
        $this->withoutExceptionHandling();

        $event = factory(Event::class)->state('empty')->create();

        $info = [
            'name' => ['en' => 'new test name', 'zh' => 'new zh test name'],
            'location' => ['en' => 'test location', 'zh' => 'zh test location'],
            'venue_name' => ['en' => 'test venue_name', 'zh' => 'zh test venue_name'],
            'venue_address' => ['en' => 'test venue_address', 'zh' => 'zh test venue_address'],
            'venue_maplink' => 'https://test.test/map',
            'start' => Carbon::today()->addMonth()->format(DatePresenter::STANDARD),
            'end' => Carbon::today()->addMonth()->format(DatePresenter::STANDARD),
            'registration_link' => 'https://test.test/registration',
        ];

        $response = $this->asAdmin()->postJson("/admin/events/{$event->id}/general-info", $info);
        $response->assertSuccessful();

        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'name' => json_encode(['en' => 'new test name', 'zh' => 'new zh test name']),
            'location' => json_encode(['en' => 'test location', 'zh' => 'zh test location']),
            'venue_name' => json_encode(['en' => 'test venue_name', 'zh' => 'zh test venue_name']),
            'venue_address' => json_encode(['en' => 'test venue_address', 'zh' => 'zh test venue_address']),
            'venue_maplink' => 'https://test.test/map',
            'start' => Carbon::today()->addMonth()->startOfDay(),
            'end' => Carbon::today()->addMonth()->endOfDay(),
            'registration_link' => 'https://test.test/registration',
        ]);
    }

    /**
     *@test
     */
    public function the_en_name_is_required_without_zh_name()
    {
        $this->assertFieldIsInvalid(['name' => ['en' => '', 'zh' => '']], 'name.en');
    }

    /**
     *@test
     */
    public function the_zh_name_is_required_without_the_en_name()
    {
        $this->assertFieldIsInvalid(['name' => ['en' => null, 'zh' => null]], 'name.zh');
    }

    /**
     *@test
     */
    public function the_maplink_must_be_a_valid_url()
    {
        $this->assertFieldIsInvalid(['venue_maplink' => 'not-a-URL']);
    }

    /**
     *@test
     */
    public function the_registration_link_must_be_a_url()
    {
        $this->assertFieldIsInvalid(['registration_link' => 'not-a-URL']);
    }

    /**
     *@test
     */
    public function start_must_be_a_valid_date()
    {
        $this->assertFieldIsInvalid(['start' => 'not-a-real-date']);
    }

    /**
     *@test
     */
    public function end_must_be_a_valid_date()
    {
        $this->assertFieldIsInvalid(['end' => 'not-a-real-date']);
    }

    /**
     *@test
     */
    public function the_end_date_must_be_after_the_start_date()
    {
        $this->assertFieldIsInvalid([
            'end' => Carbon::today()->format(DatePresenter::STANDARD),
            'start' => Carbon::tomorrow()->format(DatePresenter::STANDARD),
        ]);
    }

    private function assertFieldIsInvalid($field, $error_key = null)
    {
        $event = factory(Event::class)->state('empty')->create();

        $valid = [
            'name' => ['en' => 'new test name', 'zh' => 'new zh test name'],
            'location' => ['en' => 'test location', 'zh' => 'zh test location'],
            'venue_name' => ['en' => 'test venue_name', 'zh' => 'zh test venue_name'],
            'venue_address' => ['en' => 'test venue_address', 'zh' => 'zh test venue_address'],
            'venue_maplink' => 'https://test.test/map',
            'start' => Carbon::today()->addMonth()->format(DatePresenter::STANDARD),
            'end' => Carbon::today()->addMonth()->addDay()->format(DatePresenter::STANDARD),
            'registration_link' => 'https://test.test/registration',
        ];

        $response = $this
            ->asAdmin()
            ->postJson("/admin/events/{$event->id}/general-info", array_merge($valid, $field));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors($error_key ?? array_key_first($field));
    }
}
