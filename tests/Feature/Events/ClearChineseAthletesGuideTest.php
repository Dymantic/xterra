<?php


namespace Tests\Feature\Events;


use App\Occasions\Activity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ClearChineseAthletesGuideTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function clear_the_existing_chinese_athlete_guide()
    {
        Storage::fake(Activity::ATHLETE_GUIDE_DISK);
        $this->withoutExceptionHandling();

        $race = factory(Activity::class)->state('race')->create();
        $race->setChineseAthleteGuide(UploadedFile::fake()->create('test.pdf'));
        $filename = $race->fresh()->athlete_guide;

        $response = $this->asAdmin()->deleteJson("/admin/races/{$race->id}/chinese-athletes-guide");
        $response->assertSuccessful();

        Storage::disk(Activity::ATHLETE_GUIDE_DISK)->assertMissing($filename);

        $this->assertDatabaseHas('activities', [
            'id'                 => $race->id,
            'zh_athlete_guide'      => null,
            'zh_athlete_guide_disk' => null,
        ]);
    }
}
