<?php

namespace App\View\Components;

use Illuminate\View\Component;

class GalleryPreview extends Component
{
    public $gallery;
    public $slug;
    public $title;
    public $images;


    public function __construct($gallery)
    {
        $this->gallery = $gallery;
        $this->slug = "/galleries/{$this->gallery['slug']}";
        $this->title = $gallery['title'];
        $this->images = collect($gallery['images'] ?? []);
    }

    public function render()
    {
        return view('components.gallery-preview');
    }

    public function firstImages()
    {
        return $this->images->take(7);
    }

    public function hasExtra()
    {
        return $this->images->count() > 7;
    }

    public function extraCount()
    {
        return $this->images->count() - 7;
    }
}
