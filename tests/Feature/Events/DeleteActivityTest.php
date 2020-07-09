<?php


namespace Tests\Feature\Events;


use App\Occasions\Activity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteActivityTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function delete_an_existing_activity()
    {
        $this->withoutExceptionHandling();

        $activity = factory(Activity::class)->state('activity')->create();

        $response = $this->asAdmin()->deleteJson("/admin/activities/{$activity->id}");
        $response->assertSuccessful();

        $this->assertDatabaseMissing('activities', ['id' => $activity->id]);
    }
}
