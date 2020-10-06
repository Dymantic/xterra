<?php


namespace Tests\Feature\HomePage;


use App\HomePage;
use App\Shop\Promotion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class AttachPromotionToHomePageTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function attach_an_existing_promotion_to_the_home_page()
    {
        $this->withoutExceptionHandling();

        $promo = factory(Promotion::class)->create();

        $response = $this->asAdmin()->postJson("/admin/home-page/featured-promotion", [
            'promotion_id' => $promo->id,
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('home_pages', [
            'id' => HomePage::current()->id,
            'promotion_id' => $promo->id,
        ]);
    }

    /**
     *@test
     */
    public function the_promotion_id_must_exist_on_promotions_table()
    {
        $response = $this->asAdmin()->postJson("/admin/home-page/featured-promotion", [
            'promotion_id' => null,
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('promotion_id');

        $response = $this->asAdmin()->postJson("/admin/home-page/featured-promotion", [
            'promotion_id' => 999,
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('promotion_id');
    }
}
