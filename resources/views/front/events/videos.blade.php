@if($event['has_videos'])
<div class="pb-20 px-8" id="videos">
    <div class="max-w-4xl mx-auto">
        <p class="type-h2 uppercase mb-6">{{ trans('events.videos') }}</p>
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
@endif
