<?php


namespace Tests\Feature\Shop;


use App\Shop\Promotion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RetractPromotionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function retract_a_promotion()
    {
        $this->withoutExceptionHandling();

        $promotion = factory(Promotion::class)->state('public')->create();

        $response = $this->asAdmin()->deleteJson("/admin/public-promotions/{$promotion->id}");
        $response->assertSuccessful();

        $this->assertDatabaseHas('promotions', [
            'id'        => $promotion->id,
            'is_public' => false,
        ]);

    }
}
