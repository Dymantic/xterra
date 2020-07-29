<?php


namespace Tests\Feature\Shop;


use App\Shop\Promotion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublishPromotionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function publish_a_promotion()
    {
        $this->withoutExceptionHandling();

        $promotion = factory(Promotion::class)->state('private')->create();

        $response = $this->asAdmin()->postJson("/admin/public-promotions", [
            'promotion_id' => $promotion->id,
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('promotions', [
            'id'        => $promotion->id,
            'is_public' => true,
        ]);
    }
}
