<?php


namespace Tests\Feature\People;


use App\People\Ambassador;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RetractAmbassadorTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function retract_a_published_ambassador()
    {
        $this->withoutExceptionHandling();

        $ambassador = factory(Ambassador::class)->state('public')->create();

        $response = $this->asAdmin()->deleteJson("/admin/published-ambassadors/{$ambassador->id}");
        $response->assertSuccessful();

        $this->assertDatabaseHas('ambassadors', [
            'id'        => $ambassador->id,
            'is_public' => false,
        ]);
    }
}
