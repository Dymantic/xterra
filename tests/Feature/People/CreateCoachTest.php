<?php

namespace Tests\Feature\People;

use App\People\Coach;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreateCoachTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function create_a_coach()
    {
        $this->withoutExceptionHandling();

        $response = $this->asAdmin()->postJson("/admin/coaches", [
            'name'           => ['en' => "test name", 'zh' => "zh test name"],
            'location'       => ['en' => "test location", 'zh' => "zh test location"],
            'certifications' => ['en' => "test certifications", 'zh' => "zh test certifications"],
            'experience'     => ['en' => "test experience", 'zh' => "zh test experience"],
            'philosophy'     => ['en' => 'test philosophy', 'zh' => 'zh test philosophy'],
            'email'          => 'test@test.test',
            'phone'          => 'test phone',
            'website'        => 'https://test.test',
            'line'           => 'test_line_id',
            'social_links'   => [
                ['platform' => 'youtube', 'link' => 'https://youtube.test/test'],
                ['platform' => 'linkdin', 'link' => 'https://linkdin.test/test'],
                ['platform' => 'instagram', 'link' => 'https://instagram.test/test'],
            ]
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('coaches', [
            'name'           => json_encode(['en' => "test name", 'zh' => "zh test name"]),
            'location'       => json_encode(['en' => "test location", 'zh' => "zh test location"]),
            'certifications' => json_encode(['en' => "test certifications", 'zh' => "zh test certifications"]),
            'experience'     => json_encode(['en' => "test experience", 'zh' => "zh test experience"]),
            'philosophy'     => json_encode(['en' => 'test philosophy', 'zh' => 'zh test philosophy']),
            'email'          => 'test@test.test',
            'phone'          => 'test phone',
            'website'        => 'https://test.test',
            'line'           => 'test_line_id',
        ]);

        $this->assertCount(1, Coach::all());
        $coach = Coach::first();

        $this->assertDatabaseHas('social_links', [
            'sociable_id'   => $coach->id,
            'sociable_type' => Coach::class,
            'platform'    => 'youtube',
            'link'        => 'https://youtube.test/test'
        ]);

        $this->assertDatabaseHas('social_links', [
            'sociable_id'   => $coach->id,
            'sociable_type' => Coach::class,
            'platform'    => 'linkdin',
            'link'        => 'https://linkdin.test/test'
        ]);

        $this->assertDatabaseHas('social_links', [
            'sociable_id'   => $coach->id,
            'sociable_type' => Coach::class,
            'platform'    => 'instagram',
            'link'        => 'https://instagram.test/test'
        ]);
    }

    /**
     *@test
     */
    public function some_fields_can_be_null_or_empty()
    {
        $this->withoutExceptionHandling();

        $response = $this->asAdmin()->postJson("/admin/coaches", [
            'name'           => ['en' => "test name", 'zh' => "zh test name"],
            'location'       => ['en' => "", 'zh' => ""],
            'certifications' => ['en' => "", 'zh' => ""],
            'experience'     => ['en' => "", 'zh' => ""],
            'philosophy'     => ['en' => '', 'zh' => ''],
            'email'          => null,
            'phone'          => null,
            'website'        => null,
            'line'           => null,
            'social_links'   => []
        ]);

        $response->assertSuccessful();
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
        $valid = [
            'name'           => ['en' => "test name", 'zh' => "zh test name"],
            'location'       => ['en' => "test location", 'zh' => "zh test location"],
            'certifications' => ['en' => "test certifications", 'zh' => "zh test certifications"],
            'experience'     => ['en' => "test experience", 'zh' => "zh test experience"],
            'philosophy'     => ['en' => 'test philosophy', 'zh' => 'zh test philosophy'],
            'email'          => 'test@test.test',
            'phone'          => 'test phone',
            'website'        => 'https://test.test',
            'line'           => 'test_line_id',
            'social_links'   => [
                ['platform' => 'youtube', 'link' => 'https://youtube.test/test'],
                ['platform' => 'linkdin', 'link' => 'https://linkdin.test/test'],
                ['platform' => 'instagram', 'link' => 'https://instagram.test/test'],
            ]
        ];

        $response = $this->asAdmin()->postJson("/admin/coaches", array_merge($valid, $field));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors($error_key ?? array_key_first($field));
    }
}
