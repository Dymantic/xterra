<?php


namespace App\Blog;


class LivePostRepository
{
    protected $lang = 'en';
    protected $page_size = 15;
    protected $category = null;
    protected $tag = null;

    public function for($language)
    {
        if($language !== 'zh') {
            $language = 'en';
        }
        $this->lang = $language;

        return $this;
    }

    public function withCategory(Category $category)
    {
        $this->category = $category->id;

        return $this;
    }

    public function taggedAs(Tag $tag)
    {
        $this->tag = $tag->id;

        return $this;
    }

    public function getPost(Article $article)
    {
        $translation = $article->translations()->live()->where('language', $this->lang)->first();

        if(!$translation) {
            return null;
        }

        $result = $translation->toArray();
        $result['related_posts'] = $translation->related(app()->getLocale())->map->toArray();

        return $result;
    }

    public function getPage($page_number, $per_page = null)
    {
        if (!$per_page) {
            $per_page = $this->page_size;
        }

        $builder = Translation::with('article', 'article.categories', 'article.media', 'tags')->live();

        if ($this->category) {

            $builder = $builder->whereHas('article', function ($query) {
                return $query->whereHas('categories', function ($query) {
                    return $query->where('categories.id', $this->category);
                });
            });
        }

        if ($this->tag) {
            $builder = $builder->whereHas('tags', function ($query) {
                return $query->where('tags.id', $this->tag);
            });


        }

        $paginated = $builder->where('language', $this->lang)->latest('published_on')->paginate($per_page, ['*'],
            'page', $page_number);


        return [
            'posts'         => collect($paginated->items())->map->toArray(),
            'has_next'      => $paginated->hasMorePages(),
            'next_page'     => $page_number + 1,
            'has_previous'  => !$paginated->onFirstPage(),
            'previous_page' => $page_number - 1,
            'page'          => $page_number,
        ];
    }
}
