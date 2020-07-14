<?php


namespace Tests\Feature\Events;


use App\Occasions\Accommodation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteAccommodationTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function delete_an_existing_accommodation()
    {
        $this->withoutExceptionHandling();

        $accommodation = factory(Accommodation::class)->create();

        $response = $this->asAdmin()->deleteJson("/admin/accommodations/{$accommodation->id}");
        $response->assertSuccessful();

        $this->assertDatabaseMissing('accommodations', ['id' => $accommodation->id]);
    }
}
