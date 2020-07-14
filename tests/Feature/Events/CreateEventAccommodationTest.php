<?php


namespace Tests\Feature\Events;


use App\Occasions\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreateEventAccommodationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function create_accommodation_listing_for_event()
    {
        $this->withoutExceptionHandling();

        $event = factory(Event::class)->create();

        $response = $this->asAdmin()->postJson("/admin/events/{$event->id}/accommodation", [
            'name'        => ['en' => "test name", 'zh' => "zh test name"],
            'phone'       => 'test phone',
            'link'        => 'https://test.test',
            'description' => ['en' => "test description", 'zh' => "zh test description"],
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('accommodations', [
            'event_id'    => $event->id,
            'name'        => json_encode(['en' => "test name", 'zh' => "zh test name"]),
            'phone'       => 'test phone',
            'link'        => 'https://test.test',
            'description' => json_encode(['en' => "test description", 'zh' => "zh test description"]),
        ]);
    }

    /**
     *@test
     */
    public function the_name_field_is_required_in_at_least_one_language()
    {
        $this->assertFieldIsInvalid(['name' => []]);
    }

    /**
     *@test
     */
    public function the_description_is_required_in_at_least_one_language()
    {
        $this->assertFieldIsInvalid(['description' => []]);
    }

    /**
     *@test
     */
    public function the_link_is_required()
    {
        $this->assertFieldIsInvalid(['link' => null]);
    }

    /**
     *@test
     */
    public function the_link_must_be_a_valid_url()
    {
        $this->assertFieldIsInvalid(['link' => 'not-a-real-url']);
    }

    /**
     *@test
     */
    public function the_email_is_required_without_the_phone_number()
    {
        $this->assertFieldIsInvalid([
            'email' => null,
            'phone' => null,
        ]);
    }

    /**
     *@test
     */
    public function the_email_must_be_valid_email_format()
    {
        $this->assertFieldIsInvalid(['email' => 'not-a-valid-email']);
    }

    /**
     *@test
     */
    public function the_phone_is_required_without_the_email()
    {
        $this->assertFieldIsInvalid([
            'phone' => null,
            'email' => null,
        ]);
    }

    private function assertFieldIsInvalid($field)
    {
        $event = factory(Event::class)->create();

        $valid = [
            'name'        => ['en' => "test name", 'zh' => "zh test name"],
            'phone'       => 'test phone',
            'link'        => 'https://test.test',
            'description' => ['en' => "test description", 'zh' => "zh test description"],
        ];

        $response = $this
            ->asAdmin()
            ->postJson("/admin/events/{$event->id}/accommodation", array_merge($valid, $field));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(array_key_first($field));

    }
}
