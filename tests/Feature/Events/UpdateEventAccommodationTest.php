<?php


namespace Tests\Feature\Events;


use App\Occasions\Accommodation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class UpdateEventAccommodationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function update_an_existing_accommodation()
    {
        $this->withoutExceptionHandling();

        $accommodation = factory(Accommodation::class)->create();

        $response = $this->asAdmin()->postJson("/admin/accommodations/{$accommodation->id}", [
            'name'        => ['en' => "new name", 'zh' => "zh new name"],
            'description' => ['en' => "new description", 'zh' => "zh new description"],
            'link'        => 'https://new.test',
            'email'       => 'new@test.test',
            'phone'       => 'new phone',
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('accommodations', [
            'id'          => $accommodation->id,
            'name'        => json_encode(['en' => "new name", 'zh' => "zh new name"]),
            'description' => json_encode(['en' => "new description", 'zh' => "zh new description"]),
            'link'        => 'https://new.test',
            'email'       => 'new@test.test',
            'phone'       => 'new phone',
        ]);
    }

    /**
     *@test
     */
    public function the_name_field_is_required_in_at_least_one_language()
    {
        $this->assertFieldIsInvalid(['name' => []]);
    }

    /**
     *@test
     */
    public function the_description_is_required_in_at_least_one_language()
    {
        $this->assertFieldIsInvalid(['description' => []]);
    }

    /**
     *@test
     */
    public function the_link_is_required()
    {
        $this->assertFieldIsInvalid(['link' => null]);
    }

    /**
     *@test
     */
    public function the_link_must_be_a_valid_url()
    {
        $this->assertFieldIsInvalid(['link' => 'not-a-real-url']);
    }

    /**
     *@test
     */
    public function the_email_is_required_without_the_phone_number()
    {
        $this->assertFieldIsInvalid([
            'email' => null,
            'phone' => null,
        ]);
    }

    /**
     *@test
     */
    public function the_email_must_be_valid_email_format()
    {
        $this->assertFieldIsInvalid(['email' => 'not-a-valid-email']);
    }

    /**
     *@test
     */
    public function the_phone_is_required_without_the_email()
    {
        $this->assertFieldIsInvalid([
            'phone' => null,
            'email' => null,
        ]);
    }

    private function assertFieldIsInvalid($field)
    {
        $accommodation = factory(Accommodation::class)->create();

        $valid = [
            'name'        => ['en' => "new name", 'zh' => "zh new name"],
            'description' => ['en' => "new description", 'zh' => "zh new description"],
            'link'        => 'https://new.test',
            'email'       => 'new@test.test',
            'phone'       => 'new phone',
        ];

        $response = $this
            ->asAdmin()
            ->postJson("/admin/accommodations/{$accommodation->id}", array_merge($valid, $field));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(array_key_first($field));
    }
}
