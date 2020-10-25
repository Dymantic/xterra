<?php


namespace Tests\Feature\Media;


use App\Media\ContentCard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class OrderContentCardsTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function order_the_positions_of_the_content_cards()
    {
        $this->withoutExceptionHandling();

        $cardA = factory(ContentCard::class)->create();
        $cardB = factory(ContentCard::class)->create();
        $cardC = factory(ContentCard::class)->create();
        $cardD = factory(ContentCard::class)->create();

        $response = $this->asAdmin()->postJson("/admin/content-cards-order", [
            'card_ids' => [$cardC->id, $cardB->id, $cardA->id, $cardD->id]
        ]);
        $response->assertSuccessful();

        $this->assertSame(1, $cardC->fresh()->position);
        $this->assertSame(2, $cardB->fresh()->position);
        $this->assertSame(3, $cardA->fresh()->position);
        $this->assertSame(4, $cardD->fresh()->position);
    }

    /**
     *@test
     */
    public function the_card_ids_are_required_as_an_array()
    {
        $response = $this->asAdmin()->postJson("/admin/content-cards-order", [
            'card_ids' => null,
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('card_ids');

        $response = $this->asAdmin()->postJson("/admin/content-cards-order", [
            'card_ids' => [],
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('card_ids');

        $response = $this->asAdmin()->postJson("/admin/content-cards-order", [
            'card_ids' => 'not-an-array',
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('card_ids');
    }

    /**
     *@test
     */
    public function each_card_id_must_exists_as_id_on_content_cards_table()
    {
        $this->assertNull(ContentCard::find(99));

        $response = $this->asAdmin()->postJson("/admin/content-cards-order", [
            'card_ids' => [99],
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('card_ids.0');
    }
}
