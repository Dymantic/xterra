<?php

namespace App\Http\Controllers\Admin;

use App\Blog\Translation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PublishedTranslationsController extends Controller
{
    public function store()
    {
        request()->validate([
            'publish_date' => ['date', 'after:yesterday']
        ]);

        $translation = Translation::findOrFail(request("translation_id"));

        $translation->publish(request('publish_date'));

        return $translation->fresh();
    }

    public function destroy(Translation $translation)
    {

        $translation->retract();

        return $translation->fresh();
    }
}
