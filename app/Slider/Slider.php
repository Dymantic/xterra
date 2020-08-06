<?php


namespace App\Slider;


use App\Blog\Translation;
use App\Settings\SiteSetting;
use Illuminate\Support\Facades\Storage;

class Slider
{
    public static function setSlide($attributes)
    {
        return Slide::updateOrCreate(
            ['position' => $attributes['position']],
            ['article_id' => $attributes['article_id']]
        );
    }

    public static function clearSlide($position)
    {
        Slide::where('position', $position)->get()->each(function ($slide) {
            $slide->delete();
        });
    }

    public static function getSetSlides()
    {
        return Slide::all()->map(function ($slide) {
            return [
                'position' => $slide->position,
                'article'  => $slide->article->toArray(),
            ];
        })->values()->all();
    }

    public static function presentFor($lang)
    {
        $limit = SiteSetting::getSetting('slide_count', 6);

        $slide_translations = Slide::with('article.translations', 'article.media')
                                   ->orderBy('position')
                                   ->get()
                                   ->map(function ($slide) {
                                       return $slide->article;
                                   })
                                   ->map(function ($article) use ($lang) {
                                       return $article
                                           ->translations()
                                           ->live()
                                           ->where('language', $lang)->first();
                                   })
                                   ->filter(function ($tranlation) {
                                       return !!$tranlation;
                                   });

        if ($slide_translations->count() < $limit) {
            $extra = Translation::with('article')
                                ->live()
                                ->where('language', $lang)
                                ->whereNotIn('id', $slide_translations->pluck('id')->all())
                                ->latest('published_on')
                                ->take($limit - $slide_translations->count())
                                ->get();


            $extra->each(function ($tranlation) use ($slide_translations) {
                $slide_translations->push($tranlation);
            });


            return $slide_translations
                ->values()
                ->map(function ($translation, $index) {
                    return [
                        'position' => $index + 1,
                        'title'    => $translation->title,
                        'intro'    => $translation->intro,
                        'banner'   => $translation->article->titleImage('banner'),
                        'banner_mobile'   => $translation->article->titleImage('banner_mobile'),
                        'slug'     => $translation->fullSlug
                    ];
                })->all();
        }

        return $slide_translations
            ->take($limit)
            ->values()
            ->map(function ($translation, $index) {
                return [
                    'position' => $index + 1,
                    'title'    => $translation->title,
                    'intro'    => $translation->intro,
                    'banner'   => $translation->article->titleImage('banner'),
                    'slug'     => $translation->fullSlug
                ];
            })
            ->all();
    }

    private function allSlideTranslations($lang)
    {

    }
}
