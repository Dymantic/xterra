<?php

namespace App\Http\Controllers\Admin;

use App\Blog\Translation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TranslationBodyImagesController extends Controller
{

    public function store(Translation $translation)
    {
        request()->validate([
            'image' => ['required', 'image'],
        ]);

        $image = $translation->attachImage(request('image'));

        return ['src' => $image->getUrl('web')];
    }
}
