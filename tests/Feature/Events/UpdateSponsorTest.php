<?php


namespace Tests\Feature\Events;


use App\Occasions\Sponsor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class UpdateSponsorTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function update_an_existing_sponsor()
    {
        $this->withoutExceptionHandling();
        $sponsor = factory(Sponsor::class)->create();

        $response = $this->asAdmin()->postJson("/admin/sponsors/{$sponsor->id}", [
            'name'        => ['en' => 'new test name', 'zh' => 'zh new test name'],
            'description' => ['en' => 'new test description', 'zh' => 'zh new test description'],
            'link'        => 'https://new.test',
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('sponsors', [
            'name'        => json_encode(['en' => 'new test name', 'zh' => 'zh new test name']),
            'description' => json_encode(['en' => 'new test description', 'zh' => 'zh new test description']),
            'link'        => 'https://new.test',
        ]);
    }

    /**
     *@test
     */
    public function the_name_is_required_as_translation()
    {
        $this->assertFieldIsInvalid(['name' => 'not a translation']);
    }

    /**
     *@test
     */
    public function the_description_is_required_as_a_translation()
    {
        $this->assertFieldIsInvalid(['description' => 'not a translation']);
    }

    /**
     *@test
     */
    public function the_link_must_be_a_valid_url()
    {
        $this->assertFieldIsInvalid(['link' => 'not a url']);
    }

    private function assertFieldIsInvalid($field)
    {
        $sponsor = factory(Sponsor::class)->create();
        $valid = [
            'name'        => ['en' => 'new test name', 'zh' => 'zh new test name'],
            'description' => ['en' => 'new test description', 'zh' => 'zh new test description'],
            'link'        => 'https://new.test',
        ];

        $response = $this
            ->asAdmin()
            ->postJson("/admin/sponsors/{$sponsor->id}", array_merge($valid, $field));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(array_key_first($field));
    }
}
