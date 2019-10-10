<?php


namespace Tests\Feature\Blog;


use App\Blog\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class FetchAllRecentCommentsTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function fetch_last_two_weeks_by_default()
    {
        $this->withoutExceptionHandling();

        foreach(range(1,20) as $days_ago) {
            factory(Comment::class)->create(['created_at' => Carbon::today()->subDays($days_ago)]);
        }

        $response = $this->asAdmin()->getJson("/admin/comments");
        $response->assertStatus(200);

        $fetched = $response->decodeResponseJson();

        $this->assertCount(14, $fetched);

        collect($fetched)->each(function($comment) {
            $this->assertTrue($comment['timestamp'] >= Carbon::today()->subDays(14)->timestamp);
        });
    }

    /**
     *@test
     */
    public function can_specify_date_as_query_params()
    {
        $this->withoutExceptionHandling();

        foreach(range(1,20) as $days_ago) {
            factory(Comment::class)->create(['created_at' => Carbon::today()->subDays($days_ago)]);
        }

        $start = Carbon::today()->subDays(10)->format('Y-m-d');
        $end = Carbon::today()->subDays(5)->format('Y-m-d');

        $response = $this->asAdmin()->getJson("/admin/comments?start={$start}&end={$end}");
        $response->assertStatus(200);

        $fetched = $response->decodeResponseJson();

        $this->assertCount(6, $fetched);

        collect($fetched)->each(function($comment) {
            $this->assertTrue($comment['timestamp'] >= Carbon::today()->subDays(10)->timestamp);
            $this->assertTrue($comment['timestamp'] <= Carbon::today()->subDays(5)->timestamp);
        });
    }
}
