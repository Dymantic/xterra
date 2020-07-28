<?php


namespace Tests\Feature\People;


use App\People\Ambassador;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class UpdateAmbassadorTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function update_an_existing_ambassador()
    {
        $this->withoutExceptionHandling();

        $ambassador = factory(Ambassador::class)->create();

        $response = $this->asAdmin()->postJson("/admin/ambassadors/{$ambassador->id}", [
            'name'          => ['en' => 'new name', 'zh' => 'zh new name'],
            'about'         => ['en' => 'new about', 'zh' => 'zh new about'],
            'achievements'  => ['en' => 'new achievements', 'zh' => 'zh new achievements'],
            'collaboration' => ['en' => 'new collaboration', 'zh' => 'zh new collaboration'],
            'philosophy'    => ['en' => 'new philosophy', 'zh' => 'zh new philosophy'],
            'social_links'  => [
                ['platform' => 'youtube', 'link' => 'https://youtube.test/new'],
                ['platform' => 'linkdin', 'link' => 'https://linkdin.test/new'],
            ]
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('ambassadors', [
            'name'          => json_encode(['en' => 'new name', 'zh' => 'zh new name']),
            'about'         => json_encode(['en' => 'new about', 'zh' => 'zh new about']),
            'achievements'  => json_encode(['en' => 'new achievements', 'zh' => 'zh new achievements']),
            'collaboration' => json_encode(['en' => 'new collaboration', 'zh' => 'zh new collaboration']),
            'philosophy'    => json_encode(['en' => 'new philosophy', 'zh' => 'zh new philosophy']),
        ]);

        $this->assertCount(2, $ambassador->socialLinks);

        $this->assertTrue($ambassador->fresh()->socialLinks->contains(
            fn($link) => $link->platform === 'youtube' && $link->link === 'https://youtube.test/new'
        ));

        $this->assertTrue($ambassador->fresh()->socialLinks->contains(
            fn($link) => $link->platform === 'linkdin' && $link->link === 'https://linkdin.test/new'
        ));
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


    public function assertFieldIsInvalid($field, $error_key = null)
    {
        $ambassador = factory(Ambassador::class)->create();

        $valid = [
            'name'          => ['en' => 'new name', 'zh' => 'zh new name'],
            'about'         => ['en' => 'new about', 'zh' => 'zh new about'],
            'achievements'  => ['en' => 'new achievements', 'zh' => 'zh new achievements'],
            'collaboration' => ['en' => 'new collaboration', 'zh' => 'zh new collaboration'],
            'philosophy'    => ['en' => 'new philosophy', 'zh' => 'zh new philosophy'],
            'social_links'  => [
                ['platform' => 'youtube', 'link' => 'https://youtube.test/new'],
                ['platform' => 'linkdin', 'link' => 'https://linkdin.test/new'],
            ]
        ];

        $response = $this
            ->asAdmin()
            ->postJson("/admin/ambassadors/{$ambassador->id}", array_merge($valid, $field));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors($error_key ?? array_key_first($field));
    }
}
