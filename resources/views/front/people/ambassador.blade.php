@extends('front.base', ['all_scripts' => false])

@section('title'){{ $ambassador['name'] }}@endsection

@section('head')
    @include('front.partials.og-meta', [
        'ogTitle' => $ambassador['name'],
        'ogDescription' => $ambassador['philosophy']
    ])
@endsection

@section('content')
    <div class="py-20 px-8 max-w-4xl mx-auto">
        <div class="flex mb-12">
            <p class="type-h2 uppercase leading-none border-b-2 border-red-700">{{ trans('people.ambassador') }}</p>
        </div>
        <p class="type-banner uppercase">{{ $ambassador['name'] }}</p>

        <div class="flex flex-col md:flex-row shadow-small my-12">
            <div class="max-w-sm">
                <img src="{{ $ambassador['profile_pic']['web'] }}"
                     alt="{{ $ambassador['name'] }}">
            </div>
            <div class="p-6 bg-grey-300 flex-1 leading-tight">
                <p class="type-h2 text-red-700 uppercase">{{ trans('people.ambassador_page.about') }}:</p>
                <div>{!!  $ambassador['about'] !!}</div>
            </div>

        </div>

        <div class="my-12">
            <p class="type-h2 uppercase">{{ trans('people.ambassador_page.social_media') }}:</p>
            <div class="flex">
                @foreach($ambassador['social_links'] as $social)
                    <a href="{{ $social['link'] }}" target="_blank" rel="nofollow" class="mr-4 flex justify-center items-center w-8 h-8 rounded-full bg-red-700 hover:bg-red-500">
                        @include("svg.social-icons.{$social['platform']}", ['classes' => 'h-4 text-grey-300'])
                    </a>
                @endforeach
            </div>
        </div>

        <div class="my-12">
            <p class="type-h2 uppercase">{{ trans('people.ambassador_page.achievements') }}:</p>
            <div class="admin-edited">
                {!! $ambassador['achievements'] !!}
            </div>
        </div>

        <div class="my-12">
            <p class="type-h2 uppercase">{{ trans('people.ambassador_page.collaboration') }}:</p>
            <div class="admin-edited">
                {!! $ambassador['collaboration'] !!}
            </div>
        </div>

        <div class="my-12">
            <p class="type-h2 uppercase">{{ trans('people.ambassador_page.philosophy') }}:</p>
            <div class="admin-edited">
                {!! $ambassador['philosophy'] !!}
            </div>
        </div>

        @if(count($ambassador['videos']))
        <div class="my-12">
            <p class="type-h2 uppercase">{{ trans('people.ambassador_page.related_videos') }}:</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-16">
                @foreach($ambassador['videos'] as $video)
                    <div class="max-w-sm">
                        <p class="type-b4 mb-1">{{ $video['title'] }}</p>
                        <x-youtube-embed :video-id="$video['video_id']"></x-youtube-embed>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        @if(count($ambassador['events']))
        <div class="my-12">
            <p class="type-h2 uppercase">{{ trans('people.ambassador_page.related_events') }}:</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-16">
                @foreach($ambassador['events'] as $event)
                    @include('front.events.event-card')
                @endforeach
            </div>
        </div>
        @endif
    </div>

@endsection
