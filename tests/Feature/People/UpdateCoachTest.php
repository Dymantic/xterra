<?php


namespace Tests\Feature\People;


use App\People\Coach;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class UpdateCoachTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function update_an_existing_coach()
    {
        $this->withoutExceptionHandling();

        $coach = factory(Coach::class)->create();

        $response = $this->asAdmin()->postJson("/admin/coaches/{$coach->id}", [
            'name'           => ['en' => "new name", 'zh' => "zh new name"],
            'location'       => ['en' => "new location", 'zh' => "zh new location"],
            'certifications' => ['en' => "new certifications", 'zh' => "zh new certifications"],
            'experience'     => ['en' => "new experience", 'zh' => "zh new experience"],
            'philosophy'     => ['en' => 'new philosophy', 'zh' => 'zh new philosophy'],
            'email'          => 'new@test.test',
            'phone'          => 'new phone',
            'website'        => 'https://new.test',
            'line'           => 'new_line_id',
            'social_links'   => [
                ['platform' => 'youtube', 'link' => 'https://youtube.test/new'],
                ['platform' => 'linkdin', 'link' => 'https://linkdin.test/new'],
                ['platform' => 'instagram', 'link' => 'https://instagram.test/new'],
            ]
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('coaches', [
            'name'           => json_encode(['en' => "new name", 'zh' => "zh new name"]),
            'location'       => json_encode(['en' => "new location", 'zh' => "zh new location"]),
            'certifications' => json_encode(['en' => "new certifications", 'zh' => "zh new certifications"]),
            'experience'     => json_encode(['en' => "new experience", 'zh' => "zh new experience"]),
            'philosophy'     => json_encode(['en' => 'new philosophy', 'zh' => 'zh new philosophy']),
            'email'          => 'new@test.test',
            'phone'          => 'new phone',
            'website'        => 'https://new.test',
            'line'           => 'new_line_id',
        ]);

        $this->assertDatabaseHas('social_links', [
            'sociable_id'   => $coach->id,
            'sociable_type' => Coach::class,
            'platform'    => 'youtube',
            'link'        => 'https://youtube.test/new'
        ]);

        $this->assertDatabaseHas('social_links', [
            'sociable_id'   => $coach->id,
            'sociable_type' => Coach::class,
            'platform'    => 'linkdin',
            'link'        => 'https://linkdin.test/new'
        ]);

        $this->assertDatabaseHas('social_links', [
            'sociable_id'   => $coach->id,
            'sociable_type' => Coach::class,
            'platform'    => 'instagram',
            'link'        => 'https://instagram.test/new'
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
    public function the_location_must_be_a_translation()
    {
        $this->assertFieldIsInvalid(['location' => 'not-a-translation']);
    }

    /**
     *@test
     */
    public function the_certifications_must_be_a_translation()
    {
        $this->assertFieldIsInvalid(['certifications' => 'not-a-translation']);
    }

    /**
     *@test
     */
    public function the_experience_must_be_a_translation()
    {
        $this->assertFieldIsInvalid(['experience' => 'not-a-translation']);
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
    public function each_social_link_must_have_a_platform()
    {
        $this->assertFieldIsInvalid([
            'social_links' => [
                ['link' => 'https://test.test']
            ]
        ], 'social_links.0.platform');
    }

    /**
     *@test
     */
    public function the_link_for_each_social_link_is_required()
    {
        $this->assertFieldIsInvalid([
            'social_links' => [
                ['platform' => 'youtube', 'link' => null]
            ]
        ], 'social_links.0.link');
    }

    /**
     *@test
     */
    public function each_platform_must_be_valid()
    {
        $this->assertFieldIsInvalid([
            'social_links' => [
                ['link' => 'https://test.test', 'platform' => 'not-a-valid-platform']
            ]
        ], 'social_links.0.platform');
    }

    /**
     *@test
     */
    public function the_email_must_be_a_valid_email()
    {
        $this->assertFieldIsInvalid(['email' => 'not-a-real-email']);
    }

    /**
     *@test
     */
    public function the_website_must_be_a_url()
    {
        $this->assertFieldIsInvalid(['website' => 'not-a-url']);
    }


    private function assertFieldIsInvalid($field, $error_key = null)
    {
        $coach = factory(Coach::class)->create();

        $valid = [
            'name'           => ['en' => "new name", 'zh' => "zh new name"],
            'location'       => ['en' => "new location", 'zh' => "zh new location"],
            'certifications' => ['en' => "new certifications", 'zh' => "zh new certifications"],
            'experience'     => ['en' => "new experience", 'zh' => "zh new experience"],
            'philosophy'     => ['en' => 'new philosophy', 'zh' => 'zh new philosophy'],
            'email'          => 'new@test.test',
            'phone'          => 'new phone',
            'website'        => 'https://new.test',
            'line'           => 'new_line_id',
            'social_links'   => [
                ['platform' => 'youtube', 'link' => 'https://youtube.test/new'],
                ['platform' => 'linkdin', 'link' => 'https://linkdin.test/new'],
                ['platform' => 'instagram', 'link' => 'https://instagram.test/new'],
            ]
        ];

        $response = $this
            ->asAdmin()
            ->postJson("/admin/coaches/{$coach->id}", array_merge($valid, $field));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors($error_key ?? array_key_first($field));
    }
}
