<?php


namespace Tests\Feature\People;


use App\People\Coach;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RetractCoachTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function retract_a_published_coach()
    {
        $this->withoutExceptionHandling();

        $coach = factory(Coach::class)->state('public')->create();

        $response = $this->asAdmin()->deleteJson("/admin/published-coaches/{$coach->id}");
        $response->assertSuccessful();

        $this->assertDatabaseHas('coaches', [
            'id'        => $coach->id,
            'is_public' => false
        ]);
    }
}
