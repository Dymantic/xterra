<?php


namespace Tests\Feature\Media;


use App\Media\ContentCard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteContentCardTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function delete_an_existing_content_card()
    {
        $this->withoutExceptionHandling();

        $card = factory(ContentCard::class)->create();

        $response = $this->asAdmin()->deleteJson("/admin/content-cards/{$card->id}");
        $response->assertSuccessful();

        $this->assertDatabaseMissing('content_cards', ['id' => $card->id]);
    }
}
