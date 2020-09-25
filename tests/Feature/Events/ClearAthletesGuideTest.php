<?php


namespace Tests\Feature\Events;


use App\Occasions\Activity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ClearAthletesGuideTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function clear_an_uploaded_athletes_guide()
    {
        Storage::fake(Activity::ATHLETE_GUIDE_DISK);
        $this->withoutExceptionHandling();

        $race = factory(Activity::class)->state('race')->create();
        $race->setAthleteGuide(UploadedFile::fake()->create('test.pdf'));
        $filename = $race->fresh()->athlete_guide;

        $response = $this->asAdmin()->deleteJson("/admin/races/{$race->id}/athletes-guide");
        $response->assertSuccessful();

        Storage::disk(Activity::ATHLETE_GUIDE_DISK)->assertMissing($filename);

        $this->assertDatabaseHas('activities', [
            'id'                 => $race->id,
            'athlete_guide'      => null,
            'athlete_guide_disk' => null,
        ]);
    }
}
