<?php


namespace Tests\Feature\Events;


use App\Occasions\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class UpdateRaceCourseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function update_an_existing_course()
    {
        $this->withoutExceptionHandling();

        $course = factory(Course::class)->create();

        $response = $this->asAdmin()->postJson("/admin/courses/{$course->id}", [
            'name'        => ['en' => "new name", 'zh' => "zh new name"],
            'distance'    => ['en' => "new distance", 'zh' => "zh new distance"],
            'description' => ['en' => "new description", 'zh' => "zh new description"],
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('courses', [
            'id'          => $course->id,
            'name'        => json_encode(['en' => "new name", 'zh' => "zh new name"]),
            'distance'    => json_encode(['en' => "new distance", 'zh' => "zh new distance"]),
            'description' => json_encode(['en' => "new description", 'zh' => "zh new description"]),
        ]);
    }

    /**
     *@test
     */
    public function the_name_is_required_in_at_least_one_language()
    {
        $this->assertFieldIsInvalid(['name' => []]);
    }

    /**
     *@test
     */
    public function the_distance_is_required_in_at_least_one_language()
    {
        $this->assertFieldIsInvalid(['distance' => null]);
    }

    /**
     *@test
     */
    public function the_description_is_required_in_at_least_one_language()
    {
        $this->assertFieldIsInvalid(['description' => ['en' => null, 'zh' => '']]);
    }

    private function assertFieldIsInvalid($field)
    {
        $course = factory(Course::class)->create();

        $valid = [
            'name'        => ['en' => "new name", 'zh' => "zh new name"],
            'distance'    => ['en' => "new distance", 'zh' => "zh new distance"],
            'description' => ['en' => "new description", 'zh' => "zh new description"],
        ];

        $response = $this
            ->asAdmin()
            ->postJson("/admin/courses/{$course->id}", array_merge($valid, $field));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(array_key_first($field));
    }
}
