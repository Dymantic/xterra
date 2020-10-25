<?php


namespace Tests\Feature\Events;


use App\Occasions\Sponsor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class OrderSponsorsTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function set_the_order_of_sponsors()
    {
        $this->withoutExceptionHandling();

        $sponsorA = factory(Sponsor::class)->create();
        $sponsorB = factory(Sponsor::class)->create();
        $sponsorC = factory(Sponsor::class)->create();
        $sponsorD = factory(Sponsor::class)->create();

        $response = $this->asAdmin()->postJson("/admin/event-sponsors-order", [
            'sponsor_ids' => [$sponsorB->id, $sponsorA->id, $sponsorC->id, $sponsorD->id],
        ]);
        $response->assertSuccessful();

        $this->assertSame(1, $sponsorB->fresh()->position);
        $this->assertSame(2, $sponsorA->fresh()->position);
        $this->assertSame(3, $sponsorC->fresh()->position);
        $this->assertSame(4, $sponsorD->fresh()->position);
    }

    /**
     *@test
     */
    public function the_sponsor_ids_are_required_as_array()
    {
        $response = $this->asAdmin()->postJson("/admin/event-sponsors-order", [
            'sponsor_ids' => null,
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('sponsor_ids');

        $response = $this->asAdmin()->postJson("/admin/event-sponsors-order", [
            'sponsor_ids' => [],
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('sponsor_ids');

        $response = $this->asAdmin()->postJson("/admin/event-sponsors-order", [
            'sponsor_ids' => 'not-array',
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('sponsor_ids');
    }

    /**
     *@test
     */
    public function each_sponsor_id_must_exists_as_id_in_sponsors_table()
    {
        $this->assertNull(Sponsor::find(99));

        $response = $this->asAdmin()->postJson("/admin/event-sponsors-order", [
            'sponsor_ids' => [99],
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('sponsor_ids.0');
    }


}
