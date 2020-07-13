<?php


namespace Tests\Unit\Events;


use App\Occasions\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventPrizesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_set_prizes_for_an_event()
    {
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

        $event->setPrizes($prize_info);

        $this->assertCount(3, $event->fresh()->prizes);

        collect($prize_info)->each(fn ($prize) => $this->assertEventHasPrize($event, $prize));


    }

    /**
     *@test
     */
    public function setting_prizes_clears_any_previous_prizes()
    {
        $event = factory(Event::class)->create();

        $old_prize_info = [
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
        ];

        $event->setPrizes($old_prize_info);
        $this->assertCount(2, $event->fresh()->prizes);

        $new_prize_info = [
            [
                'category' => ['en' => "test category three", 'zh' => "zh test category three"],
                'prize'    => ['en' => "test prize three", 'zh' => "zh test prize three"],
                'position' => 1,
            ],
            [
                'category' => ['en' => "test category four", 'zh' => "zh test category four"],
                'prize'    => ['en' => "test prize four", 'zh' => "zh test prize four"],
                'position' => 2,
            ],
            [
                'category' => ['en' => "test category five", 'zh' => "zh test category five"],
                'prize'    => ['en' => "test prize five", 'zh' => "zh test prize five"],
                'position' => 3,
            ],
        ];
        $event->setPrizes($new_prize_info);

        $this->assertCount(3, $event->fresh()->prizes);
        collect($new_prize_info)->each(fn ($prize) => $this->assertEventHasPrize($event, $prize));
    }

    private function assertEventHasPrize($event, $prize)
    {
        $this->assertCount(1, $event->prizes()->where([
            ['category', json_encode($prize['category'])],
            ['prize', json_encode($prize['prize'])],
            ['position', $prize['position']]
        ])->get());
    }
}
