<?php


namespace Tests\Feature\Events;


use App\Occasions\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClearEventPrizesTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function clear_the_prizes_from_an_event()
    {
        $this->withoutExceptionHandling();

        $event =  factory(Event::class)->create();
        $event->setPrizes([
            [
                'category' => ['en' => "test category one", 'zh' => "zh test category one"],
                'prize' => ['en' => "test prize one", 'zh' => "zh test prize one"],
                'position' => 1,
            ],
            [
                'category' => ['en' => "test category two", 'zh' => "zh test category two"],
                'prize' => ['en' => "test prize two", 'zh' => "zh test prize two"],
                'position' => 2,
            ]
        ]);
        $this->assertCount(2, $event->fresh()->prizes);

        $response = $this->asAdmin()->deleteJson("/admin/events/{$event->id}/prizes");
        $response->assertSuccessful();

        $this->assertDatabaseMissing('prizes', ['event_id' => $event->id]);
        $this->assertCount(0, $event->fresh()->prizes);
    }
}
