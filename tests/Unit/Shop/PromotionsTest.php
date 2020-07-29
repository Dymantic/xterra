<?php

namespace Tests\Unit\Shop;

use App\Shop\Promotion;
use App\Shop\PromotionInfo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PromotionsTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function create_new_promotion()
    {
        $promotionInfo = new PromotionInfo([
            'title' => ['en' => "test title", 'zh' => "zh test title"],
            'writeup' => ['en' => 'test writeup', 'zh' => 'zh test writeup'],
            'button_text' => ['en' => 'test button text', 'zh' => 'zh test button text'],
            'link' => 'https://test.test/test',
        ]);

        $promotion = Promotion::new($promotionInfo);

        $this->assertInstanceOf(Promotion::class, $promotion);
        $this->assertSame('test title', $promotion->title->in('en'));
        $this->assertSame('zh test title', $promotion->title->in('zh'));
        $this->assertSame('test writeup', $promotion->writeup->in('en'));
        $this->assertSame('zh test writeup', $promotion->writeup->in('zh'));
        $this->assertSame('test button text', $promotion->button_text->in('en'));
        $this->assertSame('zh test button text', $promotion->button_text->in('zh'));
        $this->assertSame('https://test.test/test', $promotion->link);


    }

    /**
     *@test
     */
    public function can_publish_a_promotion()
    {
        $promotion = factory(Promotion::class)->state('private')->create();

        $promotion->publish();

        $this->assertTrue($promotion->fresh()->is_public);
    }

    /**
     *@test
     */
    public function can_retract_a_promotion()
    {
        $promotion = factory(Promotion::class)->state('public')->create();

        $promotion->retract();

        $this->assertFalse($promotion->fresh()->is_public);
    }

    /**
     *@test
     */
    public function can_feature_a_promotion()
    {
        $promotion = factory(Promotion::class)->state('un-featured')->create();

        $promotion->feature();

        $this->assertTrue($promotion->fresh()->is_featured);
    }

    /**
     *@test
     */
    public function can_unfeature_a_promotion()
    {
        $promotion = factory(Promotion::class)->state('featured')->create();

        $promotion->unfeature();

        $this->assertFalse($promotion->fresh()->is_featured);
    }

    /**
     *@test
     */
    public function can_scope_to_featured()
    {
        $promotionA = factory(Promotion::class)->state('featured')->create();
        $promotionB = factory(Promotion::class)->state('un-featured')->create();

        $scoped = Promotion::featured()->get();

        $this->assertCount(1, $scoped);
        $this->assertTrue($scoped->first()->is($promotionA));
    }

    /**
     *@test
     */
    public function featuring_a_promotion_automatically_unfeatures_any_other_promotion()
    {
        $promotionA = factory(Promotion::class)->state('featured')->create();
        $promotionB = factory(Promotion::class)->state('un-featured')->create();

        $promotionB->feature();

        $this->assertTrue($promotionB->fresh()->is_featured);
        $this->assertFalse($promotionA->fresh()->is_featured);

    }

    /**
     *@test
     */
    public function featuring_a_promotion_automatically_makes_it_public()
    {
        $promotion = factory(Promotion::class)->states(['private', 'un-featured'])->create();

        $promotion->feature();

        $this->assertTrue($promotion->fresh()->is_featured);
        $this->assertTrue($promotion->fresh()->is_public);
    }
}
