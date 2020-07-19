<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Media\Gallery;
use Illuminate\Http\Request;

class GalleryImagesOrderController extends Controller
{
    public function update(Gallery $gallery)
    {
        request()->validate([
            'image_ids' => ['required', 'array'],
            'image_ids.*' => ['exists:media,id']
        ]);

        $gallery->setOrder(request('image_ids'));
    }
}
