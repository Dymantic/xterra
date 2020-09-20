<?php


namespace Tests\Feature\Media;


use App\Media\ContentCard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class UpdateContentCardTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function update_an_existing_content_card()
    {
        $this->withoutExceptionHandling();

        $card = factory(ContentCard::class)->create();

        $response = $this->asAdmin()->postJson("/admin/content-cards/{$card->id}", [
            'category' => ['en' => 'new category', 'zh' => 'zh new category'],
            'title'    => ['en' => 'new title', 'zh' => 'zh new title'],
            'link'     => 'https://new-test.test/'
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('content_cards', [
            'category' => json_encode(['en' => 'new category', 'zh' => 'zh new category']),
            'title'    => json_encode(['en' => 'new title', 'zh' => 'zh new title']),
            'link'     => 'https://new-test.test/'
        ]);
    }

    /**
     *@test
     */
    public function some_empty_fields_and_states_allowed()
    {
        $this->withoutExceptionHandling();

        $card = factory(ContentCard::class)->create();

        $response = $this->asAdmin()->postJson("/admin/content-cards/{$card->id}", [
            'category' => ['en' => '', 'zh' => ''],
            'title'    => ['en' => 'test title', 'zh' => ''],
            'link'     => null,
        ]);
        $response->assertSuccessful();
    }

    /**
     *@test
     */
    public function the_title_is_required_in_at_least_one_translation()
    {
        $this->assertFieldIsInvalid(['title' => ['en' => null, 'zh' => '']]);
    }

    /**
     *@test
     */
    public function the_category_must_be_a_translation_array()
    {
        $this->assertFieldIsInvalid(['category' => 'not-even-an-array']);
    }

    private function assertFieldIsInvalid($field)
    {
        $card = factory(ContentCard::class)->create();

        $valid = [
            'category' => ['en' => 'new category', 'zh' => 'zh new category'],
            'title'    => ['en' => 'new title', 'zh' => 'zh new title'],
            'link'     => 'https://new-test.test/'
        ];

        $response = $this
            ->asAdmin()
            ->postJson("/admin/content-cards/{$card->id}", array_merge($valid, $field));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
