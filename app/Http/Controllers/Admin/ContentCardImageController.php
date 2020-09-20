<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Media\ContentCard;
use Illuminate\Http\Request;

class ContentCardImageController extends Controller
{
    public function store(ContentCard $card)
    {
        request()->validate([
            'image' => ['image'],
        ]);

        $card->setImage(request('image'));
    }

    public function destroy(ContentCard $card)
    {
        $card->clearImage();
    }
}
