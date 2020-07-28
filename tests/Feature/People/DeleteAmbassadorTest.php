<?php


namespace Tests\Feature\People;


use App\People\Ambassador;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteAmbassadorTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function delete_an_existing_ambassador()
    {
        $this->withoutExceptionHandling();

        $ambassador = factory(Ambassador::class)->create();

        $response = $this->asAdmin()->deleteJson("/admin/ambassadors/{$ambassador->id}");
        $response->assertSuccessful();

        $this->assertDatabaseMissing('ambassadors', ['id' => $ambassador->id]);
    }
}
