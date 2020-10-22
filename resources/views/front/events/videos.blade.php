<div class="py-20 px-8">
    <div class="max-w-5xl mx-auto">
        <p class="type-h2 uppercase mb-6">Event Videos</p>
        <div class="flex flex-wrap justify-center">
            @foreach($event['videos'] as $video)
                <div class="w-full max-w-sm m-4">
                    <p class="type-b4 mb-1">{{ $video['title'] }}</p>
                    <x-youtube-embed :video-id="$video['video_id']"></x-youtube-embed>
                </div>
            @endforeach
        </div>
    </div>
</div>
