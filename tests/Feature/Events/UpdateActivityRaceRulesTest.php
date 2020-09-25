<?php


namespace Tests\Feature\Events;


use App\Occasions\Activity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class UpdateActivityRaceRulesTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function update_the_race_rules_for_a_race()
    {
        $this->withoutExceptionHandling();

        $race = factory(Activity::class)->state('race')->create();
        $race->updateRules('old rules', 'en');
        $race->updateRules('old zh rules', 'zh');

        $response = $this->asAdmin()->postJson("/admin/races/{$race->id}/race-rules", [
            'rules' => 'new en rules',
            'lang' => 'en',
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('activities', [
            'id' => $race->id,
            'race_rules' => json_encode(['en' => "new en rules", 'zh' => "old zh rules"]),
        ]);

    }

    /**
     *@test
     */
    public function the_lang_is_required()
    {
        $race = factory(Activity::class)->state('race')->create();

        $response = $this->asAdmin()->postJson("/admin/races/{$race->id}/race-rules", [
            'rules' => 'test rules',
            'lang' => '',
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

        $response = $this->asAdmin()->postJson("/admin/races/{$race->id}/race-rules", [
            'rules' => 'test rules',
            'lang' => 'not-a-lang',
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('lang');
    }
}
