<?php


namespace Tests\Feature\People;


use App\People\Coach;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublishCoachTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function publish_a_coach()
    {
        $this->withoutExceptionHandling();

        $coach = factory(Coach::class)->state('private')->create();

        $response = $this->asAdmin()->postJson("/admin/published-coaches", [
            'coach_id' => $coach->id,
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('coaches', [
            'id'        => $coach->id,
            'is_public' => true,
        ]);
    }
}
