<?php


namespace App\Pages;


class PagePresenter
{

    public static function forAdmin(Page $page)
    {
        return [
            'id'           => $page->id,
            'slug'         => $page->slug,
            'title'        => $page->title->toArray(),
            'description'  => $page->description->toArray(),
            'blurb'        => $page->blurb->toArray(),
            'content_raw'  => $page->content->toArray(),
            'content_html' => ['en' => $page->contentHtml('en'), 'zh' => $page->contentHtml('zh')],
            'menu_name'    => $page->menu_name->toArray(),
            'is_public'    => $page->is_public,
            'is_draft'     => $page->isDraft(),
        ];
    }

    public static function forPublic(Page $page, $lang)
    {
        return [
            'slug'        => $page->slug,
            'full_slug'   => sprintf("/discover/%s", $page->slug),
            'title'       => $page->title->in($lang),
            'menu_name'   => $page->menu_name->in($lang),
            'description' => $page->description->in($lang),
            'blurb'       => $page->blurb->in($lang),
            'content'     => $page->contentHtml($lang),
        ];
    }
}
