<?php


namespace Tests\Feature\Blog;


use App\Blog\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class PublishTranslationTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function publish_a_translation()
    {
        $this->withoutExceptionHandling();

        $translation = factory(Translation::class)->create();

        $response = $this->asAdmin()->postJson("/admin/published-translations", [
            'translation_id' => $translation->id,
            'publish_date' => Carbon::today()->format('Y-m-d'),
        ]);
        $response->assertStatus(200);

        $this->assertTrue($translation->fresh()->published_on->isToday());
    }

    /**
     *@test
     */
    public function the_publish_date_is_not_required()
    {
        $this->withoutExceptionHandling();

        $translation = factory(Translation::class)->create();

        $response = $this->asAdmin()->postJson("/admin/published-translations", [
            'translation_id' => $translation->id,
        ]);
        $response->assertStatus(200);

        $this->assertTrue($translation->fresh()->published_on->isToday());
    }

    /**
     *@test
     */
    public function the_publish_date_must_be_a_valid_date()
    {
        $translation = factory(Translation::class)->create();
        $response = $this->asAdmin()->postJson("/admin/published-translations", [
            'translation_id' => $translation->id,
            'publish_date' => 'this-is-not-a-valid-date',
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('publish_date');
    }

    /**
     *@test
     */
    public function the_publish_date_can_not_be_in_the_past()
    {
        $translation = factory(Translation::class)->create();
        $response = $this->asAdmin()->postJson("/admin/published-translations", [
            'translation_id' => $translation->id,
            'publish_date' => Carbon::yesterday()->format('Y-m-d'),
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('publish_date');
    }
}