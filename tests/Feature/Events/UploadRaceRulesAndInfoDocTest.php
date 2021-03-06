<?php


namespace Tests\Feature\Events;


use App\Occasions\Activity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UploadRaceRulesAndInfoDocTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function upload_a_race_rules_and_info_doc_for_a_race()
    {
        $this->withoutExceptionHandling();
        Storage::fake('admin_uploads');

        $race = factory(Activity::class)->state('race')->create();
        $upload = UploadedFile::fake()->create('race_rules.pdf');

        $response = $this->asAdmin()->postJson("/admin/races/{$race->id}/race-rules-doc", [
            'rules_doc' => $upload,
        ]);
        $response->assertSuccessful();

        Storage::disk('admin_uploads')->assertExists($upload->hashName('race_rules'));

        $this->assertDatabaseHas('activities', [
            'id'              => $race->id,
            'race_rules_doc' => $upload->hashName('race_rules'),
            'race_rules_disk' => 'admin_uploads',
        ]);
    }

    /**
     *@test
     */
    public function the_doc_must_be_a_valid_file()
    {
        Storage::fake('admin_uploads');

        $race = factory(Activity::class)->state('race')->create();

        $response = $this->asAdmin()->postJson("/admin/races/{$race->id}/race-rules-doc", [
            'rules_doc' => 'not-a-file',
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('rules_doc');
    }
}
