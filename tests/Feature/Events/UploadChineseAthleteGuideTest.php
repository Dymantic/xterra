<?php


namespace Tests\Feature\Events;


use App\Occasions\Activity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UploadChineseAthleteGuideTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function upload_the_chinese_athletes_guide()
    {
        Storage::fake('admin_upload');
        $this->withoutExceptionHandling();

        $race = factory(Activity::class)->state('race')->create();
        $upload = UploadedFile::fake()->create('test_doc.pdf');

        $response = $this->asAdmin()->postJson("/admin/races/{$race->id}/chinese-athletes-guide", [
            'athlete_guide' => $upload,
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('activities', [
            'id'                 => $race->id,
            'zh_athlete_guide'      => $upload->hashName('athlete_guides'),
            'zh_athlete_guide_disk' => 'admin_uploads',
        ]);

        Storage::disk('admin_uploads')->assertExists($upload->hashName('athlete_guides'));
    }

    /**
     *@test
     */
    public function the_athlete_guide_must_be_a_valid_file()
    {
        Storage::fake('admin_upload');

        $race = factory(Activity::class)->state('race')->create();

        $response = $this->asAdmin()->postJson("/admin/races/{$race->id}/chinese-athletes-guide", [
            'athlete_guide' => 'not-a-file',
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('athlete_guide');
    }
}
