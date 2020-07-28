<?php


namespace Tests\Feature\People;


use App\People\Ambassador;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublishAmbassadorTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function make_an_ambassador_public()
    {
        $this->withoutExceptionHandling();

        $ambassador = factory(Ambassador::class)->state('private')->create();

        $response = $this->asAdmin()->postJson("/admin/published-ambassadors", [
            'ambassador_id' => $ambassador->id,
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('ambassadors', [
            'id'        => $ambassador->id,
            'is_public' => true,
        ]);
    }
}
