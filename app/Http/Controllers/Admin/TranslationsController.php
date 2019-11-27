<?php

namespace App\Http\Controllers\Admin;

use App\Blog\Article;
use App\Blog\Translation;
use App\Rules\UnusedTranslation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class TranslationsController extends Controller
{

    public function show(Translation $translation)
    {
        return $translation->toArray();
    }

    public function store(Article $article)
    {
        $data = request()->validate([
            'lang' => ['required', Rule::in(['en', 'zh']), new UnusedTranslation($article)],
            'title' => ['required'],
        ]);

        return $article->addTranslation($data['lang'], $data['title'], auth()->user());
    }

    public function update(Translation $translation)
    {
        request()->validate([
            'title' => ['required', Rule::unique('translations')->ignore($translation->id)],
            'tags' => 'array'
        ]);

        $translation->update(request()->only('title', 'intro', 'description', 'body', 'author_name'));

        $translation->setTags(request('tags'));
    }
}
