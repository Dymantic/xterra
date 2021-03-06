<?php


namespace Tests\Feature\Events;


use App\Occasions\Activity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ClearChineseRaceRulesDocumentTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function clear_the_existing_race_rules_document()
    {
        Storage::fake(Activity::RACE_RULES_DISK);
        $this->withoutExceptionHandling();

        $race = factory(Activity::class)->state('race')->create();
        $race->setChineseRulesAndInfoDoc(UploadedFile::fake()->create('test.pdf'));
        $filepath = $race->fresh()->race_rules_doc;

        $response = $this->asAdmin()->deleteJson("/admin/races/{$race->id}/chinese-race-rules-doc");
        $response->assertSuccessful();

        Storage::disk(Activity::RACE_RULES_DISK)->assertMissing($filepath);

        $this->assertNull($race->fresh()->zh_race_rules_doc);
        $this->assertNull($race->fresh()->zh_race_rules_disk);
    }
}
