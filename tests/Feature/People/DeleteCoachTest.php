<?php


namespace Tests\Feature\People;


use App\People\Coach;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteCoachTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function delete_an_existing_coach()
    {
        $this->withoutExceptionHandling();

        $coach = factory(Coach::class)->create();
        $coach->setSocialLinks([
            ['platform' => 'youtube', 'link' => 'https://youtube.test/test'],
            ['platform' => 'instagram', 'link' => 'https://instagram.test/test'],
        ]);

        $response = $this->asAdmin()->deleteJson("/admin/coaches/{$coach->id}");
        $response->assertSuccessful();

        $this->assertDatabaseMissing('coaches', ['id' => $coach->id]);
        $this->assertDatabaseMissing('social_links', ['sociable_id' => $coach->id]);
    }
}
