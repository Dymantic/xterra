<?php


namespace Tests\Feature\Events;


use App\Media\EmbeddableVideo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteEmbeddableVideoTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function delete_an_existing_embeddable_video()
    {
        $this->withoutExceptionHandling();

        $video = factory(EmbeddableVideo::class)->state('youtube')->create();

        $response = $this->asAdmin()->deleteJson("/admin/embeddable-videos/{$video->id}");
        $response->assertSuccessful();

        $this->assertDatabaseMissing('embeddable_videos', ['id' => $video->id]);
    }
}
