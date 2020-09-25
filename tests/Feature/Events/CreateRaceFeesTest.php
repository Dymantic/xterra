<?php


namespace Tests\Feature\Events;


use App\Occasions\Activity;
use App\Occasions\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreateRaceFeesTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function create_fees_for_a_race()
    {
        $this->withoutExceptionHandling();

        $race = factory(Activity::class)->state('race')->create();

        $fees_data = [
            [
                'category' => ['en' => 'test category one', 'zh' => 'zh test category one'],
                'fee' => 'NT$1000',
                'position' => 1,
            ],
            [
                'category' => ['en' => 'test category two', 'zh' => 'zh test category two'],
                'fee' => 'NT$2000',
                'position' => 2,
            ],
            [
                'category' => ['en' => 'test category three', 'zh' => 'zh test category three'],
                'fee' => 'NT$3000',
                'position' => 3,
            ],
        ];

        $response = $this->asAdmin()->postJson("/admin/races/{$race->id}/fees", [
            'fees' => $fees_data,
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('fees', [
            'costly_id' => $race->id,
            'costly_type' => Activity::class,
            'category' => json_encode(['en' => 'test category one', 'zh' => 'zh test category one']),
            'fee' => 'NT$1000',
            'position' => 1
        ]);

        $this->assertDatabaseHas('fees', [
            'costly_id' => $race->id,
            'costly_type' => Activity::class,
            'category' => json_encode(['en' => 'test category two', 'zh' => 'zh test category two']),
            'fee' => 'NT$2000',
            'position' => 2
        ]);

        $this->assertDatabaseHas('fees', [
            'costly_id' => $race->id,
            'costly_type' => Activity::class,
            'category' => json_encode(['en' => 'test category three', 'zh' => 'zh test category three']),
            'fee' => 'NT$3000',
            'position' => 3
        ]);
    }

    /**
     *@test
     */
    public function the_fees_are_required()
    {
        $this->assertDataIsInvalid(['fees' => null]);
    }

    /**
     *@test
     */
    public function the_fees_must_be_an_array()
    {
        $this->assertDataIsInvalid(['fees' => 'not-an-array']);
    }

    /**
     *@test
     */
    public function each_fee_entry_must_be_an_array()
    {
        $this->assertDataIsInvalid(['fees' => [
            'not-an-array',
        ]], 'fees.0');
    }

    /**
     *@test
     */
    public function each_fees_entry_must_have_a_fee()
    {
        $this->assertDataIsInvalid(['fees' => [
            [
                'category' => ['en' => 'test category', 'zh' => 'zh test category'],
                'fee' => null,
                'position' => 1
            ]
        ]], 'fees.0.fee');
    }

    /**
     *@test
     */
    public function each_fees_entry_must_have_a_category()
    {
        $this->assertDataIsInvalid(['fees' => [
            [
                'category' => null,
                'fee' => 'NT$200',
                'position' => 1
            ]
        ]], 'fees.0.category');
    }

    /**
     *@test
     */
    public function each_fees_entry_category_must_have_at_least_one_translation()
    {
        $this->assertDataIsInvalid(['fees' => [
            [
                'category' => ['en' => null, 'zh' => null],
                'fee' => 'NT$500',
                'position' => 1
            ]
        ]], 'fees.0.category');
    }

    /**
     *@test
     */
    public function each_fee_entry_must_have_a_position()
    {
        $this->assertDataIsInvalid(['fees' => [
            [
                'category' => ['en' => 'test category', 'zh' => 'zh test category'],
                'fee' => 'NT$500',
                'position' => null
            ]
        ]], 'fees.0.position');
    }

    /**
     *@test
     */
    public function each_fee_entry_position_must_be_an_integer()
    {
        $this->assertDataIsInvalid(['fees' => [
            [
                'category' => ['en' => 'test category', 'zh' => 'zh test category'],
                'fee' => 'NT$500',
                'position' => 'not-an-integer'
            ]
        ]], 'fees.0.position');
    }

    private function assertDataIsInvalid($data, $error_key = null)
    {
        $race = factory(Activity::class)->state('race')->create();

        $response = $this->asAdmin()->postJson("/admin/races/{$race->id}/fees", $data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors($error_key ?? array_key_first($data));
    }
}
