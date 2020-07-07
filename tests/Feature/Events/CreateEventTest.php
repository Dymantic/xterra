<?php

namespace Tests\Feature\Events;

use App\Occasions\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreateEventTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function create_a_new_event()
    {
        $this->withoutExceptionHandling();

        $response = $this->asAdmin()->postJson("/admin/events", [
            'name' => ['en' => 'test name', 'zh' => '']
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('events', [
            'name' => json_encode(['en' => 'test name', 'zh' => '']),
            'location' => json_encode(['en' => '', 'zh' => '']),
            'venue_name' => json_encode(['en' => '', 'zh' => '']),
            'venue_address' => json_encode(['en' => '', 'zh' => '']),
            'overview' => json_encode(['en' => '', 'zh' => '']),
        ]);

    }

    /**
     *@test
     */
    public function the_name_is_required()
    {
        $response = $this->asAdmin()->postJson("/admin/events", [
            'name' => null
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('name');
    }

    /**
     *@test
     */
    public function the_en_name_is_required_if_zh_is_not_present()
    {
        $response = $this->asAdmin()->postJson("/admin/events", [
            'name' => ['en' => '', 'zh' => '']
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('name.en');
    }

    /**
     *@test
     */
    public function the_zh_name_is_required_without_the_en_name()
    {
        $response = $this->asAdmin()->postJson("/admin/events", [
            'name' => ['en' => '', 'zh' => '']
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('name.zh');
    }
}
