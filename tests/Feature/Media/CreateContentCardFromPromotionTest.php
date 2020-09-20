<?php


namespace Tests\Feature\Media;


use App\Shop\Promotion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Lang;
use Tests\TestCase;

class CreateContentCardFromPromotionTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function create_a_new_content_card_from_an_existing_promo()
    {
        $this->withoutExceptionHandling();

        $promo = factory(Promotion::class)->create();

        $response = $this->asAdmin()->postJson("/admin/promotion-content-cards", [
            'promotion_id' => $promo->id,
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('content_cards', [
            'category' => json_encode([
                'en' => Lang::get('content-cards.shop', [], 'en'),
                'zh' => Lang::get('content-cards.shop', [], 'zh'),
            ]),
            'title' => json_encode($promo->title->toArray()),
            'link' => $promo->link,
        ]);
    }
}
