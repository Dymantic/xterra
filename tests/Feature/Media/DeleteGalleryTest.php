<?php


namespace Tests\Feature\Media;


use App\Media\Gallery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteGalleryTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function delete_an_existing_gallery()
    {
        $this->withoutExceptionHandling();

        $gallery = factory(Gallery::class)->create();

        $response = $this->asAdmin()->deleteJson("/admin/galleries/{$gallery->id}");
        $response->assertSuccessful();

        $this->assertDatabaseMissing('galleries', ['id' => $gallery->id]);
    }
}
