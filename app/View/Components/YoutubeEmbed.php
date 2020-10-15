<?php

namespace App\View\Components;

use Illuminate\View\Component;

class YoutubeEmbed extends Component
{

    public $videoId;

    public function __construct($videoId)
    {
        $this->videoId = $videoId;
    }

    public function render()
    {
        return view('components.youtube-embed');
    }
}
