<?php

namespace Tests\Unit\Slider;

use App\Blog\Article;
use App\Blog\Translation;
use App\Settings\SiteSetting;
use App\Slider\Slide;
use App\Slider\Slider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SliderTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function set_a_slide()
    {
        $article = factory(Article::class)->create();

        Slider::setSlide(['position' => 1, 'article_id' => $article->id]);

        $this->assertDatabaseHas('slides', ['position' => 1, 'article_id' => $article->id]);
    }

    /**
     * @test
     */
    public function override_a_slide_position()
    {
        $articleA = factory(Article::class)->create();
        Slider::setSlide(['position' => 1, 'article_id' => $articleA->id]);

        $articleB = factory(Article::class)->create();
        Slider::setSlide(['position' => 1, 'article_id' => $articleB->id]);

        $this->assertCount(1, Slide::where('position', 1)->get());
        $this->assertDatabaseHas('slides', ['position' => 1, 'article_id' => $articleB->id]);
    }

    /**
     * @test
     */
    public function clear_a_slide()
    {
        $article = factory(Article::class)->create();
        Slider::setSlide(['position' => 1, 'article_id' => $article->id]);

        Slider::clearSlide(1);

        $this->assertDatabaseMissing('slides', [
            'position' => 1,
        ]);
    }

    /**
     * @test
     */
    public function get_set_slides()
    {
        $articleA = factory(Article::class)->create();
        $articleB = factory(Article::class)->create();

        Slider::setSlide(['position' => 1, 'article_id' => $articleA->id]);
        Slider::setSlide(['position' => 2, 'article_id' => $articleB->id]);

        $expected = [
            [
                'position' => 1,
                'article'  => $articleA->toArray(),
            ],
            [
                'position' => 2,
                'article'  => $articleB->toArray(),
            ]
        ];

        $this->assertEquals($expected, Slider::getSetSlides());

    }

    /**
     * @test
     */
    public function present_live_slideshow()
    {
        Storage::fake('media');

        $articleA = factory(Article::class)->create();
        $imgA = $articleA->setTitleImage(UploadedFile::fake()->image('art_a.png'));
        $articleB = factory(Article::class)->create();
        $imgB = $articleB->setTitleImage(UploadedFile::fake()->image('art_b.png'));
        $articleC = factory(Article::class)->create();
        $imgC = $articleC->setTitleImage(UploadedFile::fake()->image('art_c.png'));
        $articleD = factory(Article::class)->create();
        $imgD = $articleD->setTitleImage(UploadedFile::fake()->image('art_d.png'));
        $articleE = factory(Article::class)->create();
        $imgE = $articleE->setTitleImage(UploadedFile::fake()->image('art_e.png'));
        $articleF = factory(Article::class)->create();
        $imgF = $articleF->setTitleImage(UploadedFile::fake()->image('art_f.png'));
        $articleG = factory(Article::class)->create();
        $imgG = $articleG->setTitleImage(UploadedFile::fake()->image('art_g.png'));

        $translationA = factory(Translation::class)
            ->states(['live', 'en'])->create([
                'article_id'   => $articleA,
                'published_on' => Carbon::yesterday()->subDays(1)
            ]);
        $translationB = factory(Translation::class)
            ->states(['live', 'en'])->create([
                'article_id'   => $articleB,
                'published_on' => Carbon::yesterday()->subDays(2)
            ]);
        $translationC = factory(Translation::class)
            ->states(['live', 'en'])->create([
                'article_id'   => $articleC,
                'published_on' => Carbon::yesterday()->subDays(3)
            ]);
        $translationD = factory(Translation::class)
            ->states(['live', 'en'])->create([
                'article_id'   => $articleE,
                'published_on' => Carbon::yesterday()->subDays(4)
            ]);
        $translationE = factory(Translation::class)
            ->states(['live', 'en'])->create([
                'article_id'   => $articleG,
                'published_on' => Carbon::yesterday()->subDays(5)
            ]);

        $translationF = factory(Translation::class)
            ->states(['live', 'zh'])->create([
                'article_id'   => $articleA,
                'published_on' => Carbon::yesterday()->subDays(6)
            ]);
        $translationG = factory(Translation::class)
            ->states(['live', 'zh'])->create([
                'article_id'   => $articleC,
                'published_on' => Carbon::yesterday()->subDays(7)
            ]);
        $translationH = factory(Translation::class)
            ->states(['live', 'zh'])->create([
                'article_id'   => $articleD,
                'published_on' => Carbon::yesterday()->subDays(8)
            ]);
        $translationI = factory(Translation::class)
            ->states(['live', 'zh'])->create([
                'article_id'   => $articleE,
                'published_on' => Carbon::yesterday()->subDays(9)
            ]);
        $translationJ = factory(Translation::class)
            ->states(['live', 'zh'])->create([
                'article_id'   => $articleF,
                'published_on' => Carbon::yesterday()->subDays(10)
            ]);


        Slider::setSlide(['position' => 1, 'article_id' => $articleC->id]);
        Slider::setSlide(['position' => 2, 'article_id' => $articleA->id]);
        Slider::setSlide(['position' => 3, 'article_id' => $articleE->id]);
        Slider::setSlide(['position' => 4, 'article_id' => $articleD->id]);
        Slider::setSlide(['position' => 5, 'article_id' => $articleB->id]);

        SiteSetting::saveSetting('slide_count', 5);

        $expected_en = [
            [
                'position' => 1,
                'title'    => $translationC->title,
                'intro'    => $translationC->intro,
                'banner'   => $imgC->getUrl('banner'),
                'slug'     => $translationC->fullSlug,
            ],
            [
                'position' => 2,
                'title'    => $translationA->title,
                'intro'    => $translationA->intro,
                'banner'   => $imgA->getUrl('banner'),
                'slug'     => $translationA->fullSlug,
            ],
            [
                'position' => 3,
                'title'    => $translationD->title,
                'intro'    => $translationD->intro,
                'banner'   => $imgE->getUrl('banner'),
                'slug'     => $translationD->fullSlug,
            ],
            [
                'position' => 4,
                'title'    => $translationB->title,
                'intro'    => $translationB->intro,
                'banner'   => $imgB->getUrl('banner'),
                'slug'     => $translationB->fullSlug,
            ],
            [
                'position' => 5,
                'title'    => $translationE->title,
                'intro'    => $translationE->intro,
                'banner'   => $imgG->getUrl('banner'),
                'slug'     => $translationE->fullSlug,
            ],
        ];

        $expected_zh = [
            [
                'position' => 1,
                'title'    => $translationG->title,
                'intro'    => $translationG->intro,
                'banner'   => $imgC->getUrl('banner'),
                'slug'     => $translationG->fullSlug,
            ],
            [
                'position' => 2,
                'title'    => $translationF->title,
                'intro'    => $translationF->intro,
                'banner'   => $imgA->getUrl('banner'),
                'slug'     => $translationF->fullSlug,
            ],
            [
                'position' => 3,
                'title'    => $translationI->title,
                'intro'    => $translationI->intro,
                'banner'   => $imgE->getUrl('banner'),
                'slug'     => $translationI->fullSlug,
            ],
            [
                'position' => 4,
                'title'    => $translationH->title,
                'intro'    => $translationH->intro,
                'banner'   => $imgD->getUrl('banner'),
                'slug'     => $translationH->fullSlug,
            ],
            [
                'position' => 5,
                'title'    => $translationJ->title,
                'intro'    => $translationJ->intro,
                'banner'   => $imgF->getUrl('banner'),
                'slug'     => $translationJ->fullSlug,
            ],
        ];

        $this->assertEquals($expected_en, Slider::presentFor('en'));
        $this->assertEquals($expected_zh, Slider::presentFor('zh'));

    }
}
