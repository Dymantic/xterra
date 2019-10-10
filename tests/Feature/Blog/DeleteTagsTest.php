<?php


namespace Tests\Feature\Blog;


use App\Blog\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteTagsTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function delete_a_batch_of_tags()
    {
        $this->withoutExceptionHandling();

        $tagA = factory(Tag::class)->create();
        $tagB = factory(Tag::class)->create();
        $tagC = factory(Tag::class)->create();
        $tagD = factory(Tag::class)->create();

        $response = $this->asAdmin()->deleteJson("/admin/tags", [
            'tag_ids' => [$tagA->id, $tagB->id, $tagC->id]
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseMissing('tags', ['id' => $tagA->id]);
        $this->assertDatabaseMissing('tags', ['id' => $tagB->id]);
        $this->assertDatabaseMissing('tags', ['id' => $tagC->id]);
        $this->assertDatabaseHas('tags', ['id' => $tagD->id]);
    }

    /**
     *@test
     */
    public function the_tag_ids_are_required()
    {
        $response = $this->asAdmin()->deleteJson("/admin/tags", [
            'tag_ids' => null
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('tag_ids');
    }

    /**
     *@test
     */
    public function tag_ids_must_be_an_array()
    {
        $tag = factory(Tag::class)->create();
        $response = $this->asAdmin()->deleteJson("/admin/tags", [
            'tag_ids' => $tag->id
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('tag_ids');

        $this->assertDatabaseHas('tags', ['id' => $tag->id]);
    }

    /**
     *@test
     */
    public function tag_ids_must_be_integers()
    {
        $response = $this->asAdmin()->deleteJson("/admin/tags", [
            'tag_ids' => ['foo', 'bar']
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('tag_ids.0');
        $response->assertJsonValidationErrors('tag_ids.1');
    }
}
