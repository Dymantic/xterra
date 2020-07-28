<?php


namespace Tests\Feature\People;


use App\People\Ambassador;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreateAmbassadorTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function create_a_new_ambassador()
    {
        $this->withoutExceptionHandling();

        $response = $this->asAdmin()->postJson("/admin/ambassadors", [
            'name'          => ['en' => 'test name', 'zh' => 'zh test name'],
            'about'         => ['en' => 'test about', 'zh' => 'zh test about'],
            'achievements'  => ['en' => 'test achievements', 'zh' => 'zh test achievements'],
            'collaboration' => ['en' => 'test collaboration', 'zh' => 'zh test collaboration'],
            'philosophy'    => ['en' => 'test philosophy', 'zh' => 'zh test philosophy'],
            'social_links'   => [
                ['platform' => 'youtube', 'link' => 'https://youtube.test/test'],
                ['platform' => 'linkdin', 'link' => 'https://linkdin.test/test'],
                ['platform' => 'instagram', 'link' => 'https://instagram.test/test'],
            ]
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('ambassadors', [
            'name'          => json_encode(['en' => 'test name', 'zh' => 'zh test name']),
            'about'         => json_encode(['en' => 'test about', 'zh' => 'zh test about']),
            'achievements'  => json_encode(['en' => 'test achievements', 'zh' => 'zh test achievements']),
            'collaboration' => json_encode(['en' => 'test collaboration', 'zh' => 'zh test collaboration']),
            'philosophy'    => json_encode(['en' => 'test philosophy', 'zh' => 'zh test philosophy']),
        ]);

        $this->assertCount(1, Ambassador::all());
        $ambassador = Ambassador::first();

        $this->assertDatabaseHas('social_links', [
            'sociable_id' => $ambassador->id,
            'sociable_type' => Ambassador::class,
            'platform' => 'youtube',
            'link' => 'https://youtube.test/test'
        ]);

        $this->assertDatabaseHas('social_links', [
            'sociable_id' => $ambassador->id,
            'sociable_type' => Ambassador::class,
            'platform' => 'linkdin',
            'link' => 'https://linkdin.test/test'
        ]);

        $this->assertDatabaseHas('social_links', [
            'sociable_id' => $ambassador->id,
            'sociable_type' => Ambassador::class,
            'platform' => 'instagram',
            'link' => 'https://instagram.test/test'
        ]);
    }

    /**
     *@test
     */
    public function the_name_is_required_in_at_least_one_language()
    {
        $this->assertFieldIsInvalid(['name' => []]);
    }

    /**
     *@test
     */
    public function the_about_must_be_a_translation()
    {
        $this->assertFieldIsInvalid(['about' => 'not-a-translation']);
    }

    /**
     *@test
     */
    public function the_achievements_must_be_a_translation()
    {
        $this->assertFieldIsInvalid(['achievements' => 'not-a-translation']);
    }

    /**
     *@test
     */
    public function the_collaboration_must_be_a_translation()
    {
        $this->assertFieldIsInvalid(['collaboration' => 'not-a-translation']);
    }

    /**
     *@test
     */
    public function the_philosophy_must_be_a_translation()
    {
        $this->assertFieldIsInvalid(['philosophy' => 'not-a-translation']);
    }

    /**
     *@test
     */
    public function the_social_links_must_be_an_array()
    {
        $this->assertFieldIsInvalid(['social_links' => 'not-an-array']);
    }

    /**
     *@test
     */
    public function the_platform_is_required_for_each_social_link()
    {
        $this->assertFieldIsInvalid(['social_links' => [
            ['platform' => null, 'link' => 'https://test.test/test']
        ]], 'social_links.0.platform');
    }

    /**
     *@test
     */
    public function the_platform_is_must_be_on_the_list_for_each_social_link()
    {
        $this->assertFieldIsInvalid(['social_links' => [
            ['platform' => 'not-a-valid-platform', 'link' => 'https://test.test/test']
        ]], 'social_links.0.platform');
    }

    /**
     *@test
     */
    public function the_link_is_required_for_each_social_link()
    {
        $this->assertFieldIsInvalid(['social_links' => [
            ['platform' => 'youtube', 'link' => '']
        ]], 'social_links.0.link');
    }

    private function assertFieldIsInvalid($field, $error_key = null)
    {
        $valid = [
            'name'          => ['en' => 'test name', 'zh' => 'zh test name'],
            'about'         => ['en' => 'test about', 'zh' => 'zh test about'],
            'achievements'  => ['en' => 'test achievements', 'zh' => 'zh test achievements'],
            'collaboration' => ['en' => 'test collaboration', 'zh' => 'zh test collaboration'],
            'philosophy'    => ['en' => 'test philosophy', 'zh' => 'zh test philosophy'],
            'social_links'   => [
                ['platform' => 'youtube', 'link' => 'https://youtube.test/test'],
                ['platform' => 'linkdin', 'link' => 'https://linkdin.test/test'],
                ['platform' => 'instagram', 'link' => 'https://instagram.test/test'],
            ]
        ];

        $response = $this->asAdmin()->postJson("/admin/ambassadors", array_merge($valid, $field));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors($error_key ?? array_key_first($field));
    }
}
