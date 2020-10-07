<?php


namespace Tests\Feature\Events;


use App\Occasions\Activity;
use App\Occasions\Event;
use App\Occasions\Prize;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreateEventRacePrizesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function create_the_en_prizes_for_a_race()
    {
        $this->withoutExceptionHandling();

        $race = factory(Activity::class)->state('race')->create();

        $response = $this->asAdmin()->postJson("/admin/races/{$race->id}/prizes", [
            'prizes' => $this->validPrizeData(),
            'lang' => 'en'
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('activities', [
            'id' => $race->id,
            'prizes'    => json_encode(['en' => $this->validPrizeData(), 'zh' => ""]),
        ]);

    }

    /**
     *@test
     */
    public function the_prizes_are_required()
    {
        $this->assertDataIsInvalid(['prizes' => null]);
    }

    /**
     *@test
     */
    public function the_language_is_required()
    {
        $this->assertDataIsInvalid(['lang' => null]);
    }

    /**
     *@test
     */
    public function the_language_must_be_en_or_zh()
    {
        $this->assertDataIsInvalid(['lang' => 'neither-en-nor-zh']);
    }



    private function assertDataIsInvalid($data, $error_key = null)
    {
        $race = factory(Activity::class)->create();

        $response = $this->asAdmin()->postJson("/admin/races/{$race->id}/prizes", $data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertJsonValidationErrors($error_key ?? array_key_first($data));
    }

    private function validPrizeData()
    {
        return '{
            "time" : 1602031485102,
    "blocks" : [
        {
            "type" : "table",
            "data" : {
            "content" : [
                [
                    "heading one",
                    "heading two",
                    "heading three"
                ],
                [
                    "row one",
                    "row two",
                    "row three"
                ]
            ]
            }
        }
    ],
    "version" : "2.18.0"
}';
    }
}
