<?php

namespace Tests\Unit\Pages;

use App\Pages\Page;
use App\Pages\PageMetaInfo;
use App\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class PagesTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function make_a_new_page()
    {
        $page_info = new PageMetaInfo([
            'title' => ['en' => 'test title', 'zh' => 'zh test title'],
            'description' => ['en' => 'test description', 'zh' => 'zh test description'],
            'blurb' => ['en' => 'test blurb', 'zh' => 'zh test blurb'],
            'menu_name' => ['en' => 'test menu name', 'zh' => 'zh test menu name'],
        ]);

        $page = Page::new($page_info);

        $this->assertInstanceOf(Page::class, $page);
        $this->assertEquals('test title', $page->title->in('en'));
        $this->assertEquals('zh test title', $page->title->in('zh'));
        $this->assertEquals('test description', $page->description->in('en'));
        $this->assertEquals('zh test description', $page->description->in('zh'));
        $this->assertEquals('test blurb', $page->blurb->in('en'));
        $this->assertEquals('zh test blurb', $page->blurb->in('zh'));
        $this->assertEquals('test menu name', $page->menu_name->in('en'));
        $this->assertEquals('zh test menu name', $page->menu_name->in('zh'));
    }

    /**
     *@test
     */
    public function making_new_page_generates_slug_from_en_title()
    {
        $page_info = new PageMetaInfo([
            'title' => ['en' => 'test title', 'zh' => 'zh test title'],
            'description' => ['en' => 'test description', 'zh' => 'zh test description'],
            'blurb' => ['en' => 'test blurb', 'zh' => 'zh test blurb'],
            'content'     => ['en' => 'test content', 'zh' => 'zh test content'],
            'menu_name' => ['en' => 'test menu name', 'zh' => 'zh test menu name'],
        ]);

        $page = Page::new($page_info);

        $this->assertEquals('test-title', $page->fresh()->slug);
    }

    /**
     *@test
     */
    public function updating_a_draft_will_update_the_slug()
    {
        $page = factory(Page::class)->state('draft')->create();

        $page_info = new PageMetaInfo([
            'title' => ['en' => 'new title', 'zh' => 'zh new title'],
            'description' => ['en' => 'new description', 'zh' => 'zh new description'],
            'blurb' => ['en' => 'new blurb', 'zh' => 'zh new blurb'],
            'content'     => ['en' => 'new content', 'zh' => 'zh new content'],
            'menu_name' => ['en' => 'new menu name', 'zh' => 'zh new menu name'],
        ]);

        $page->update($page_info->toArray());

        $this->assertEquals('new-title', $page->fresh()->slug);
    }

    /**
     *@test
     */
    public function updating_published_page_will_not_update_slug()
    {
        $page = factory(Page::class)->state('public')->create([
            'first_published' => Carbon::yesterday(),
        ]);
        $original_slug = $page->slug;

        $page_info = new PageMetaInfo([
            'title' => ['en' => 'new title', 'zh' => 'zh new title'],
            'description' => ['en' => 'new description', 'zh' => 'zh new description'],
            'blurb' => ['en' => 'new blurb', 'zh' => 'zh new blurb'],
            'content'     => ['en' => 'new content', 'zh' => 'zh new content'],
            'menu_name' => ['en' => 'new menu name', 'zh' => 'zh new menu name'],
        ]);

        $page->update($page_info->toArray());

        $this->assertEquals($original_slug, $page->fresh()->slug);
        $this->assertEquals('new title', $page->fresh()->title->in('en'));
    }

    /**
     *@test
     */
    public function can_publish_a_draft_page()
    {
        $page = factory(Page::class)->state('draft')->create();

        $page->publish();

        $this->assertTrue($page->fresh()->is_public);
        $this->assertTrue($page->fresh()->first_published->isToday());
    }

    /**
     *@test
     */
    public function publishing_a_previously_public_page_does_not_change_first_published_date()
    {
        $page = factory(Page::class)->state('private')->create([
            'first_published' => Carbon::yesterday(),
        ]);

        $page->publish();

        $this->assertTrue($page->fresh()->is_public);
        $this->assertFalse($page->fresh()->first_published->isToday());
    }

    /**
     *@test
     */
    public function can_retract_a_page()
    {
        $page = factory(Page::class)->state('public')->create();

        $page->retract();

        $this->assertFalse($page->fresh()->is_public);
    }

    /**
     *@test
     */
    public function can_set_the_contents_for_a_page_in_a_lang()
    {
        $page = factory(Page::class)->create([
            'content' => new Translation(['en' => "old content", 'zh' => "zh old content"])
        ]);

        $page->setContent('new en contents', 'en');

        $this->assertSame("new en contents", $page->fresh()->content->in('en'));
        $this->assertSame("zh old content", $page->fresh()->content->in('zh'));

        $page->setContent('new zh contents', 'zh');

        $this->assertSame("new en contents", $page->fresh()->content->in('en'));
        $this->assertSame("new zh contents", $page->fresh()->content->in('zh'));
    }
}
