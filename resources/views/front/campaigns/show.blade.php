@extends('front.base')

@section('content')
<div class="video-banner min-h-banner relative flex flex-col justify-end items-center" style="background-image: url({{ $campaign['banner_image']['full'] }}); background-size: cover;">
    @if($campaign['banner_video'])
    <div class="absolute inset-0" style="z-index: -1">
        <video src="{{ $campaign['banner_video'] }}" class="hidden banner-video w-full h-full object-cover" muted autoplay loop></video>
    </div>
    @endif
{{--    <p class="text-white type-banner text-center">{{ $campaign['title'] }}</p>--}}
    <a href="" class="px-8 py-2 uppercase rounded-lg bg-white text-grey-700 type-h3 shadow-lg mb-12">Watch Video</a>
</div>
@endsection
