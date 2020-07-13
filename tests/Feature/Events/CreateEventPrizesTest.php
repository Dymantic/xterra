<?php


namespace Tests\Feature\Events;


use App\Occasions\Event;
use App\Occasions\Prize;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreateEventPrizesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function create_the_prizes_for_an_event()
    {
        $this->withoutExceptionHandling();

        $event = factory(Event::class)->create();

        $prize_info = [
            [
                'category' => ['en' => "test category one", 'zh' => "zh test category one"],
                'prize'    => ['en' => "test prize one", 'zh' => "zh test prize one"],
                'position' => 1,
            ],
            [
                'category' => ['en' => "test category two", 'zh' => "zh test category two"],
                'prize'    => ['en' => "test prize two", 'zh' => "zh test prize two"],
                'position' => 2,
            ],
            [
                'category' => ['en' => "test category three", 'zh' => "zh test category three"],
                'prize'    => ['en' => "test prize three", 'zh' => "zh test prize three"],
                'position' => 3,
            ],
        ];

        $response = $this->asAdmin()->postJson("/admin/events/{$event->id}/prizes", [
            'prizes' => $prize_info,
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('prizes', [
            'event_id' => $event->id,
            'category' => json_encode(['en' => "test category one", 'zh' => "zh test category one"]),
            'prize'    => json_encode(['en' => "test prize one", 'zh' => "zh test prize one"]),
            'position' => 1,
        ]);
        $this->assertDatabaseHas('prizes', [
            'event_id' => $event->id,
            'category' => json_encode(['en' => "test category two", 'zh' => "zh test category two"]),
            'prize'    => json_encode(['en' => "test prize two", 'zh' => "zh test prize two"]),
            'position' => 2,
        ]);
        $this->assertDatabaseHas('prizes', [
            'event_id' => $event->id,
            'category' => json_encode(['en' => "test category three", 'zh' => "zh test category three"]),
            'prize'    => json_encode(['en' => "test prize three", 'zh' => "zh test prize three"]),
            'position' => 3,
        ]);

    }

    /**
     *@test
     */
    public function the_prizes_are_required()
    {
        $this->assertDataIsInvalid(['prizes' => null]);
    }

    /**
     *@test
     */
    public function the_prizes_must_be_an_array()
    {
        $this->assertDataIsInvalid(['prizes' => 'not-an-array']);
    }

    /**
     *@test
     */
    public function each_prizes_entry_must_be_an_array()
    {
        $this->assertDataIsInvalid(['prizes' => ['not-an-array']], 'prizes.0');
    }

    /**
     *@test
     */
    public function each_prize_entry_must_have_a_category_with_at_least_one_translation()
    {
        $this->assertDataIsInvalid(['prizes' => [
            [
                'category' => null,
                'prize' => ['en' => "test prize", 'zh' => "zh test prize"],
                'position' => 1,
            ]
        ]], 'prizes.0.category');
    }

    /**
     *@test
     */
    public function each_prize_entry_must_have_a_prize_with_at_least_one_translation()
    {
        $this->assertDataIsInvalid(['prizes' => [
            [
                'prize' => ['en' => "", 'zh' => ""],
                'category' => ['en' => "test category", 'zh' => "zh test category"],
                'position' => 1,
            ]
        ]], 'prizes.0.prize');
    }

    /**
     *@test
     */
    public function the_position_is_required()
    {
        $this->assertDataIsInvalid(['prizes' => [
            [
                'category' => ['en' => "test category", 'zh' => "zh test category"],
                'prize' => ['en' => "test prize", 'zh' => "zh test prize"],
            ]
        ]], 'prizes.0.position');
    }

    /**
     *@test
     */
    public function the_position_must_be_an_integer()
    {
        $this->assertDataIsInvalid(['prizes' => [
            [
                'category' => ['en' => "test category", 'zh' => "zh test category"],
                'prize' => ['en' => "test prize", 'zh' => "zh test prize"],
                'position' => 'not-an-integer'
            ]
        ]], 'prizes.0.position');
    }

    private function assertDataIsInvalid($data, $error_key = null)
    {
        $event = factory(Event::class)->create();

        $response = $this->asAdmin()->postJson("/admin/events/{$event->id}/prizes", $data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertJsonValidationErrors($error_key ?? array_key_first($data));
    }
}
