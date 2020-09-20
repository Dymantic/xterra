<?php


namespace Tests\Feature\Events;


use App\Occasions\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteEventCourseTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function delete_an_existing_course()
    {
        $this->withoutExceptionHandling();

        $course = factory(Course::class)->create();

        $response = $this->asAdmin()->deleteJson("/admin/courses/{$course->id}");
        $response->assertSuccessful();

        $this->assertDatabaseMissing('courses', ['id' => $course->id]);
    }
}
