<?php


namespace Tests\Feature\Blog;


use App\Blog\Reply;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class FetchRecentRepliesTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function fetch_last_two_weeks_by_default()
    {
        $this->withoutExceptionHandling();

        foreach(range(1,20) as $days_ago) {
            factory(Reply::class)->create(['created_at' => Carbon::today()->subDays($days_ago)]);
        }

        $response = $this->asAdmin()->getJson("/admin/replies");
        $response->assertStatus(200);

        $fetched = $response->json();

        $this->assertCount(14, $fetched);

        collect($fetched)->each(function($comment) {
            $this->assertTrue($comment['timestamp'] >= Carbon::today()->subDays(14)->timestamp);
        });
    }

    /**
     *@test
     */
    public function with_specified_dates()
    {
        $this->withoutExceptionHandling();

        foreach(range(1,20) as $days_ago) {
            factory(Reply::class)->create(['created_at' => Carbon::today()->subDays($days_ago)]);
        }

        $start = Carbon::today()->subDays(10)->format('Y-m-d');
        $end = Carbon::today()->subDays(5)->format('Y-m-d');

        $response = $this->asAdmin()->getJson("/admin/replies?start={$start}&end={$end}");
        $response->assertStatus(200);

        $fetched = $response->json();

        $this->assertCount(6, $fetched);

        collect($fetched)->each(function($comment) {
            $this->assertTrue($comment['timestamp'] >= Carbon::today()->subDays(10)->timestamp);
            $this->assertTrue($comment['timestamp'] <= Carbon::today()->subDays(5)->timestamp);
        });
    }
}
