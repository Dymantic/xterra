<?php


namespace Tests\Feature\Blog;


use App\Blog\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateTranslationTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function update_a_translation()
    {
        $this->withoutExceptionHandling();

        $translation = factory(Translation::class)->state('new_en')->create([]);

        $response = $this->asAdmin()->postJson("/admin/translations/{$translation->id}", [
            'title' => 'new title',
            'intro' => 'test introduction',
            'description' => 'test description',
            'body' => 'test body',
            'tags' => ['tag one', 'tag two', 'tag three']
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('translations', [
            'id' => $translation->id,
            'language' => 'en',
            'title' => 'new title',
            'intro' => 'test introduction',
            'description' => 'test description',
            'body' => 'test body',
        ]);

        $expected_tags = ['tag one', 'tag two', 'tag three'];
        $this->assertEquals($expected_tags, $translation->tags->pluck('tag_name')->all());
    }

    /**
     *@test
     */
    public function the_title_is_required()
    {
        $translation = factory(Translation::class)->state('new_en')->create([]);

        $response = $this->asAdmin()->postJson("/admin/translations/{$translation->id}", [
            'title' => '',
            'intro' => 'test introduction',
            'description' => 'test description',
            'body' => 'test body',
            'tags' => ['tag one', 'tag two', 'tag three']
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('title');
    }

    /**
     *@test
     */
    public function the_tags_must_be_an_array()
    {
        $translation = factory(Translation::class)->state('new_en')->create([]);

        $response = $this->asAdmin()->postJson("/admin/translations/{$translation->id}", [
            'title' => 'test title',
            'intro' => 'test introduction',
            'description' => 'test description',
            'body' => 'test body',
            'tags' => 'just-a-string-tag',
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('tags');
    }
}