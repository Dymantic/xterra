<?php


namespace Tests\Feature\Media;


use App\Media\Gallery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class UpdateGalleryInfoTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function update_the_info_for_an_existing_gallery()
    {
        $this->withoutExceptionHandling();

        $gallery = factory(Gallery::class)->create();

        $response = $this->asAdmin()->postJson("/admin/galleries/{$gallery->id}", [
            'title'       => ['en' => "new title", 'zh' => "zh new title"],
            'description' => ['en' => "new description", 'zh' => "zh new description"],
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('galleries', [
            'title'       => json_encode(['en' => "new title", 'zh' => "zh new title"]),
            'description' => json_encode(['en' => "new description", 'zh' => "zh new description"]),
        ]);
    }

    /**
     *@test
     */
    public function the_title_is_required_in_at_least_one_language()
    {
        $this->assertFieldIsInvalid(['title' => ['en' => null]]);
    }

    /**
     *@test
     */
    public function the_description_must_be_an_array()
    {
        $this->assertFieldIsInvalid(['description' => 'not-an-array']);
    }

    private function assertFieldIsInvalid($field)
    {
        $gallery = factory(Gallery::class)->create();

        $valid = [
            'title'       => ['en' => "new title", 'zh' => "zh new title"],
            'description' => ['en' => "new description", 'zh' => "zh new description"],
        ];

        $response = $this
            ->asAdmin()
            ->postJson("/admin/galleries/{$gallery->id}", array_merge($valid, $field));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(array_key_first($field));
    }
}
