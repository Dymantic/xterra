<?php


namespace Tests\Feature\Events;


use App\Occasions\Activity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class UpdatePrizeNotesForRaceTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function update_the_prize_notes_for_a_race()
    {
        $this->withoutExceptionHandling();

        $race = factory(Activity::class)->state('race')->create();

        $response = $this->asAdmin()->postJson("/admin/races/{$race->id}/schedule-notes", [
            'notes' => ['en' => 'test notes', 'zh' => 'zh test notes'],
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('activities', [
            'id' => $race->id,
            'schedule_notes' => json_encode(['en' => 'test notes', 'zh' => 'zh test notes']),
        ]);
    }

    /**
     *@test
     */
    public function the_notes_must_be_a_translation_array()
    {
        $race = factory(Activity::class)->state('race')->create();

        $response = $this->asAdmin()->postJson("/admin/races/{$race->id}/schedule-notes", [
            'notes' => 'not-even-an-array',
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('notes');
    }
}
