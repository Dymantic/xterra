<?php


namespace Tests\Feature\Events;


use App\Occasions\Activity;
use App\Occasions\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClearRaceFeesTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function clear_the_fees_for_a_race()
    {
        $this->withoutExceptionHandling();

        $race = factory(Activity::class)->state('race')->create();

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

        $race->setFees($fees);

        $response = $this->asAdmin()->deleteJson("/admin/races/{$race->id}/fees");
        $response->assertSuccessful();

        $this->assertDatabaseMissing('fees', [
            'costly_id' => $race->id,
            'costly_type' => Activity::class,
        ]);
    }
}
