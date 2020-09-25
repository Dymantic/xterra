<?php


namespace Tests\Feature\Events;


use App\Occasions\Activity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class UpdateRaceInfoTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function update_the_race_info_for_a_race()
    {
        $this->withoutExceptionHandling();

        $race = factory(Activity::class)->state('race')->create();
        $race->updateInfo('old info', 'en');
        $race->updateInfo('old zh info', 'zh');

        $response = $this->asAdmin()->postJson("/admin/races/{$race->id}/race-info", [
            'info' => 'new en info',
            'lang' => 'en',
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('activities', [
            'id' => $race->id,
            'race_info' => json_encode(['en' => 'new en info', 'zh' => 'old zh info']),
        ]);
    }



    /**
     *@test
     */
    public function the_lang_is_required()
    {
        $race = factory(Activity::class)->state('race')->create();

        $response = $this->asAdmin()->postJson("/admin/races/{$race->id}/race-info", [
            'info' => 'test info',
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('lang');
    }

    /**
     *@test
     */
    public function the_lang_must_be_a_valid_lang_code()
    {
        $race = factory(Activity::class)->state('race')->create();

        $response = $this->asAdmin()->postJson("/admin/races/{$race->id}/race-info", [
            'info' => 'test info',
            'lang' => 'not-a-lang',
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('lang');
    }
}
