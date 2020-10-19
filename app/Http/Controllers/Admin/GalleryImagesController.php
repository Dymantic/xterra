<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Media\Gallery;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class GalleryImagesController extends Controller
{
    public function store(Gallery $gallery)
    {
        request()->validate([
            'image' => ['required', 'image'],
        ]);

        $gallery->addImage(request('image'));
    }

    public function delete(Gallery $gallery, Media $image)
    {
        abort_unless($image->model->is($gallery), 403);

        $image->delete();
    }
}
