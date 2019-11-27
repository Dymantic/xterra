<?php


namespace Tests\Feature\Blog;


use App\Blog\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NoOverwritingTranslationTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function an_article_will_not_update_if_it_duplicates_another()
    {
        $translationA = factory(Translation::class)
            ->state('en')
            ->create([
                'title' => 'The original title',
                'intro' => 'The original intro',
                'description' => 'The original description',
                'body' => 'The original body',
            ]);

        $translationB = factory(Translation::class)
            ->state('en')
            ->create([
                'title' => 'The newer title',
                'intro' => 'The newer intro',
                'description' => 'The newer description',
                'body' => 'The newer body',
            ]);

        $response = $this->asAdmin()->postJson("/admin/translations/{$translationA->id}", [
            'title' => 'The newer title',
            'intro' => 'The newer intro',
            'description' => 'The newer description',
            'body' => 'The newer body',
        ]);

        $response->assertStatus(422);

        $this->assertDatabaseHas('translations', [
            'id' => $translationA->id,
            'title' => 'The original title',
            'intro' => 'The original intro',
            'description' => 'The original description',
            'body' => 'The original body',
        ]);
    }
}
