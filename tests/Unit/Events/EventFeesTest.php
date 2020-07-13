<?php


namespace Tests\Unit\Events;


use App\Occasions\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventFeesTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function set_event_fees()
    {
        $event = factory(Event::class)->create();

        $fees = [
            [
                'category' => ['en' => 'test category one', 'zh' => 'zh test category one'],
                'fee' => 'NT$1000',
                'position' => 1,
            ],
            [
                'category' => ['en' => 'test category two', 'zh' => 'zh test category two'],
                'fee' => 'NT$2000',
                'position' => 2,
            ],
            [
                'category' => ['en' => 'test category three', 'zh' => 'zh test category three'],
                'fee' => 'NT$3000',
                'position' => 3,
            ],
        ];

        $event->setFees($fees);

        $this->assertCount(3, $event->fees);

        $this->assertEventHasFee($event, [
            'category' => ['en' => 'test category one', 'zh' => 'zh test category one'],
            'fee' => 'NT$1000',
            'position' => 1,
        ]);

        $this->assertEventHasFee($event, [
            'category' => ['en' => 'test category two', 'zh' => 'zh test category two'],
            'fee' => 'NT$2000',
            'position' => 2,
        ]);

        $this->assertEventHasFee($event, [
            'category' => ['en' => 'test category three', 'zh' => 'zh test category three'],
            'fee' => 'NT$3000',
            'position' => 3,
        ]);
    }

    /**
     *@test
     */
    public function setting_fees_clears_old_fee_entries()
    {
        $event = factory(Event::class)->create();

        $old_fees = [
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

        $event->setFees($old_fees);

        $new_fees = [
            [
                'category' => ['en' => 'new category one', 'zh' => 'zh new category one'],
                'fee' => 'NT$500',
                'position' => 1,
            ],
            [
                'category' => ['en' => 'new category two', 'zh' => 'zh new category two'],
                'fee' => 'NT$700',
                'position' => 2,
            ],
        ];

        $event->setFees($new_fees);

        $this->assertCount(2, $event->fresh()->fees);

        $this->assertEventHasFee($event, [
            'category' => ['en' => 'new category one', 'zh' => 'zh new category one'],
            'fee' => 'NT$500',
            'position' => 1,
        ]);

        $this->assertEventHasFee($event, [
            'category' => ['en' => 'new category two', 'zh' => 'zh new category two'],
            'fee' => 'NT$700',
            'position' => 2,
        ]);


    }

    /**
     *@test
     */
    public function can_clear_fees()
    {
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

        $this->assertCount(2, $event->fresh()->fees);

        $event->clearFees();

        $this->assertCount(0, $event->fresh()->fees);
    }

    private function assertEventHasFee($event, $fee)
    {
        $this->assertCount(1, $event->fees()->where([
            ['category', json_encode($fee['category'])],
            ['fee', $fee['fee']],
            ['position', $fee['position']]
        ])->get());
    }
}
