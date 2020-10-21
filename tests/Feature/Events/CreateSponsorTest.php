<?php


namespace Tests\Feature\Events;


use App\Occasions\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreateSponsorTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function create_a_new_sponsor_for_an_event()
    {
        $this->withoutExceptionHandling();
        $event = factory(Event::class)->create();

        $response = $this->asAdmin()->postJson("/admin/events/{$event->id}/sponsors", [
            'name'        => ['en' => 'test name', 'zh' => 'zh test name'],
            'description' => ['en' => 'test description', 'zh' => 'zh test description'],
            'link'        => 'https://test.test',
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('sponsors', [
            'event_id'    => $event->id,
            'name'        => json_encode(['en' => 'test name', 'zh' => 'zh test name']),
            'description' => json_encode(['en' => 'test description', 'zh' => 'zh test description']),
            'link'        => 'https://test.test',
        ]);
    }

    /**
     *@test
     */
    public function empty_states_are_allowed()
    {
        $event = factory(Event::class)->create();

        $response = $this->asAdmin()->postJson("/admin/events/{$event->id}/sponsors", [
            'name'        => ['en' => '', 'zh' => ''],
            'description' => ['en' => '', 'zh' => ''],
            'link'        => null,
        ]);
        $response->assertSuccessful();
    }

    /**
     *@test
     */
    public function the_name_is_required_as_translation()
    {
        $this->assertFieldIsInvalid(['name' => 'not a translation']);
    }

    /**
     *@test
     */
    public function the_description_is_required_as_a_translation()
    {
        $this->assertFieldIsInvalid(['description' => 'not a translation']);
    }

    /**
     *@test
     */
    public function the_link_must_be_a_valid_url()
    {
        $this->assertFieldIsInvalid(['link' => 'not a url']);
    }

    private function assertFieldIsInvalid($field)
    {
        $event = factory(Event::class)->create();
        $valid = [
            'name'        => ['en' => 'test name', 'zh' => 'zh test name'],
            'description' => ['en' => 'test description', 'zh' => 'zh test description'],
            'link'        => 'https://test.test',
        ];

        $response = $this
            ->asAdmin()
            ->postJson("/admin/events/{$event->id}/sponsors", array_merge($valid, $field));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(array_key_first($field));
    }
}
