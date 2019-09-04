<?php

namespace App\Http\Controllers\Admin;

use App\Blog\Article;
use App\Blog\Translation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class TranslationsController extends Controller
{

    public function store(Article $article)
    {
        $data = request()->validate([
            'lang' => ['required', Rule::in(['en', 'zh'])],
            'title' => ['required'],
        ]);

        return $article->addTranslation($data['lang'], $data['title'], auth()->user());
    }

    public function update(Translation $translation)
    {
        request()->validate([
            'title' => 'required',
            'tags' => 'array'
        ]);

        $translation->update(request()->only('title', 'intro', 'description', 'body'));

        $translation->setTags(request('tags'));
    }
}
