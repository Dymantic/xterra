<?php


namespace Tests\Feature\Shop;


use App\Shop\Promotion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class UpdatePromotionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function update_an_existing_promotion()
    {
        $this->withoutExceptionHandling();

        $promotion = factory(Promotion::class)->create();

        $response = $this->asAdmin()->postJson("/admin/promotions/{$promotion->id}", [
            'title'       => ['en' => 'new title', 'zh' => 'zh new title'],
            'writeup'     => ['en' => 'new writeup', 'zh' => 'zh new writeup'],
            'button_text' => ['en' => "new button text", 'zh' => "zh new button text"],
            'link'        => 'https://test.test/test',
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('promotions', [
            'title'       => json_encode(['en' => 'new title', 'zh' => 'zh new title']),
            'writeup'     => json_encode(['en' => 'new writeup', 'zh' => 'zh new writeup']),
            'button_text' => json_encode(['en' => "new button text", 'zh' => "zh new button text"]),
            'link'        => 'https://test.test/test',
        ]);
    }

    /**
     *@test
     */
    public function some_fields_may_be_empty()
    {
        $promotion = factory(Promotion::class)->create();

        $response = $this->asAdmin()->postJson("/admin/promotions/{$promotion->id}", [
            'title'       => ['en' => null, 'zh' => 'zh new title'],
            'writeup'     => ['en' => null, 'zh' => null],
            'button_text' => ['en' => null, 'zh' => null],
            'link'        => '',
        ]);

        $response->assertSuccessful();
    }

    /**
     * @test
     */
    public function the_title_requires_at_least_one_translation()
    {
        $this->assertFieldIsInvalid(['title' => []]);
    }

    /**
     * @test
     */
    public function the_writeup_must_be_a_translation()
    {
        $this->assertFieldIsInvalid(['writeup' => 'not-a-translation-array']);
    }

    /**
     *@test
     */
    public function the_button_text_must_be_a_translation()
    {
        $this->assertFieldIsInvalid(['button_text' => 'not-a-translation-array']);
    }

    /**
     * @test
     */
    public function the_link_must_be_a_url()
    {
        $this->assertFieldIsInvalid(['link' => 'not-a-url']);
    }

    private function assertFieldIsInvalid($field)
    {
        $promotion = factory(Promotion::class)->create();

        $valid = [
            'title'       => ['en' => 'new title', 'zh' => 'zh new title'],
            'writeup'     => ['en' => 'new writeup', 'zh' => 'zh new writeup'],
            'button_text' => ['en' => "new button text", 'zh' => "zh new button text"],
            'link'        => 'https://test.test/test',
        ];

        $response = $this
            ->asAdmin()
            ->postJson("/admin/promotions/{$promotion->id}", array_merge($valid, $field));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(array_key_first($field));
    }
}
