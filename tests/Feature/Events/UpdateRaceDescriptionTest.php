<?php


namespace Tests\Feature\Events;


use App\Occasions\Activity;
use App\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateRaceDescriptionTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function update_the_description_for_an_existing_race()
    {
        $this->withoutExceptionHandling();
        $race = factory(Activity::class)->create([
            'description' => new Translation(['en' => 'test description', 'zh' => 'zh test description']),
        ]);

        $response = $this->asAdmin()->postJson("/admin/races/{$race->id}/description", [
            'description' => 'new description',
            'lang' => 'en',
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('activities', [
            'id' => $race->id,
            'description' => json_encode(['en' => "new description", 'zh' => "zh test description"])
        ]);
    }
}
