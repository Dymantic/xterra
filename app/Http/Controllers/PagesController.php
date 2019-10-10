<?php

namespace App\Http\Controllers;

use App\Blog\Article;
use App\Blog\Category;
use App\Blog\Tag;
use App\Slider\Slider;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function home()
    {
        return view('front.blog.index', [
            'categories' => Category::all()->map(function($cat) {
                return [
                    'slug' => $cat->slug,
                    'name' => $cat->title[app()->getLocale()]
                ];
            })->all(),
            'slideshow' => Slider::presentFor(app()->getLocale()),
            'posts'  => app('live-posts')->for(app()->getLocale())->getPage(request('page', 1)),
            'page_title' => trans('blog-index.latest_articles'),
        ]);
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        return view('front.blog.index', [
            'posts' => app('live-posts')->for(app()->getLocale())->withCategory($category)->getPage(request('page', 1)),
            'categories' => Category::all()->map(function($cat) {
                return [
                    'slug' => $cat->slug,
                    'name' => $cat->title[app()->getLocale()]
                ];
            })->all(),
            'page_title' => $category->title[app()->getLocale()]
        ]);
    }

    public function tag($slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();

        return view('front.blog.index', [
            'posts' => app('live-posts')->for(app()->getLocale())->taggedAs($tag)->getPage(request('page', 1)),
            'categories' => Category::all()->map(function($cat) {
                return [
                    'slug' => $cat->slug,
                    'name' => $cat->title[app()->getLocale()]
                ];
            })->all(),
            'tag_title' => $tag->tag_name,
            'all_tags' => Tag::inUse()->get()->map->toArrayWithCount(),
        ]);
    }

    public function article($article_slug)
    {
        $article = Article::where('slug', $article_slug)->firstOrFail();
        return view('front.blog.show', [
            'article' => app('live-posts')->for(app()->getLocale())->getPost($article),
            'categories' => Category::all()->map(function($cat) {
                return [
                    'slug' => $cat->slug,
                    'name' => $cat->title[app()->getLocale()]
                ];
            })->all(),
        ]);
    }
}
