<?php


namespace Tests\Feature\Events;


use App\Occasions\Sponsor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteSponsorTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function delete_an_existing_sponsor()
    {
        $this->withoutExceptionHandling();
        $sponsor = factory(Sponsor::class)->create();

        $response = $this->asAdmin()->deleteJson("/admin/sponsors/{$sponsor->id}");
        $response->assertSuccessful();

        $this->assertDatabaseMissing('sponsors', ['id' => $sponsor->id]);
    }
}
