<?php


namespace Tests\Feature\Events;


use App\Occasions\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClearEventFeesTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function clear_the_fees_for_an_event()
    {
        $this->withoutExceptionHandling();

        $event = factory(Event::class)->create();

        $fees = [
            [
                'category' => ['en' => 'old category one', 'zh' => 'zh old category one'],
                'fee' => 'NT$1000',
                'position' => 1,
            ],
            [
                'category' => ['en' => 'old category two', 'zh' => 'zh old category two'],
                'fee' => 'NT$2000',
                'position' => 2,
            ],
        ];

        $event->setFees($fees);

        $response = $this->asAdmin()->deleteJson("/admin/events/{$event->id}/fees");
        $response->assertSuccessful();

        $this->assertDatabaseMissing('fees', ['event_id' => $event->id]);
    }
}
