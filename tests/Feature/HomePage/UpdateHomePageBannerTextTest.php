<?php


namespace Tests\Feature\HomePage;


use App\HomePage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class UpdateHomePageBannerTextTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function update_the_homepage_banner_text()
    {
        $this->withoutExceptionHandling();

        $response = $this->asAdmin()->postJson("/admin/home-page/banner-text", [
            'heading'    => ['en' => 'test heading', 'zh' => 'zh test heading'],
            'subheading' => ['en' => 'test subheading', 'zh' => 'zh test subheading'],
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('home_pages', [
            'id'                => HomePage::current()->id,
            'banner_heading'    => json_encode(['en' => "test heading", 'zh' => "zh test heading"]),
            'banner_subheading' => json_encode(['en' => "test subheading", 'zh' => "zh test subheading"]),
        ]);
    }

    /**
     * @test
     */
    public function the_heading_is_required_as_a_translation()
    {
        $this->assertFieldIsInvalid(['heading' => null]);
        $this->assertFieldIsInvalid(['heading' => 'not-a-translation']);
    }

    /**
     * @test
     */
    public function the_subheading_is_required_as_a_translation()
    {
        $this->assertFieldIsInvalid(['subheading' => null]);
        $this->assertFieldIsInvalid(['subheading' => 'not-a-translation']);
    }



    private function assertFieldIsInvalid($field)
    {
        $valid = [
            'heading'    => ['en' => 'test heading', 'zh' => 'zh test heading'],
            'subheading' => ['en' => 'test subheading', 'zh' => 'zh test subheading'],
        ];

        $response = $this
            ->asAdmin()
            ->postJson("/admin/home-page/banner-text", array_merge($valid, $field));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(array_key_first($field));
    }
}
