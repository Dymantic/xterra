<?php


namespace Tests\Feature\Shop;


use App\Shop\Promotion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeletePromotionTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function delete_an_existing_promotion()
    {
        $this->withoutExceptionHandling();

        $promotion = factory(Promotion::class)->create();

        $response = $this->asAdmin()->deleteJson("/admin/promotions/{$promotion->id}");
        $response->assertSuccessful();

        $this->assertDatabaseMissing('promotions', ['id' => $promotion->id]);
    }
}
