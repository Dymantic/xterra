<?php


namespace Tests\Feature\Shop;


use App\Shop\Promotion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MarkPromotionAsFeaturedTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function mark_a_promotion_as_featured()
    {
        $this->withoutExceptionHandling();

        $promotion = factory(Promotion::class)->state('un-featured')->create();

        $response = $this->asAdmin()->postJson("/admin/featured-promotions", [
            'promotion_id' => $promotion->id,
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('promotions', [
            'id'          => $promotion->id,
            'is_featured' => true,
        ]);

    }
}
