@extends('front.base', ['all_scripts' => false])

@section('title'){{ $coach['name'] }}@endsection

@section('head')
    @include('front.partials.og-meta', [
        'ogTitle' => $coach['name'],
        'ogDescription' => $coach['philosophy']
    ])
@endsection

@section('content')
    <div class="py-20 px-8 max-w-4xl mx-auto">
        <div class="flex mb-12">
            <p class="type-h2 uppercase leading-none border-b-2 border-red-700">{{ trans('people.coach') }}</p>
        </div>
        <p class="type-banner uppercase">{{ $coach['name'] }}</p>

        <div class="flex flex-col md:flex-row shadow-small my-12">
            <div class="max-w-sm">
                <img src="{{ $coach['profile_pic']['web'] }}"
                     alt="{{ $coach['name'] }}">
            </div>
            <div class="p-6 bg-gray-100 flex-1 leading-tight">
                <p class="type-h2 text-red-700 uppercase">{{ trans('people.coach_page.location') }}:</p>
                <p>{{ $coach['location'] }}</p>

                <p class="type-h2 text-red-700 uppercase mt-8">{{ trans('people.coach_page.contact') }}:</p>
                <p>
                    <a href="mailto:{{ $coach['email'] }}" target="_blank" rel="nofollow"
                       class="hover:text-red-500">
                        {{ $coach['email'] }}
                    </a>
                </p>
                <p>{{ $coach['phone'] }}</p>
                <p>{{ $coach['line'] }}</p>
                <p><a href="{{ $coach['website'] }}" target="_blank" rel="nofollow"
                      class="hover:text-red-500">
                        {{ $coach['website'] }}
                    </a></p>
            </div>

        </div>

        <div class="my-12">
            <p class="type-h2 uppercase">{{ trans('people.coach_page.social_media') }}:</p>
            <div class="flex">
                @foreach($coach['social_links'] as $social)
                    <a href="{{ $social['link'] }}" target="_blank" rel="nofollow" class="mr-4 flex justify-center items-center w-8 h-8 rounded-full bg-red-700 hover:bg-red-500">
                        @include("svg.social-icons.{$social['platform']}", ['classes' => 'h-4 text-grey-300'])
                    </a>
                @endforeach
            </div>

        </div>

        <div class="my-12">
            <p class="type-h2 uppercase">{{ trans('people.coach_page.certifications') }}:</p>
            <div class="admin-edited">
                {!! $coach['certifications'] !!}
            </div>
        </div>

        <div class="my-12">
            <p class="type-h2 uppercase">{{ trans('people.coach_page.experience') }}:</p>
            <div class="admin-edited">
                {!! $coach['experience'] !!}
            </div>
        </div>

        <div class="my-12">
            <p class="type-h2 uppercase">{{ trans('people.coach_page.philosophy') }}:</p>
            <div class="admin-edited">
                {!! $coach['philosophy'] !!}
            </div>
        </div>

        @if(count($coach['videos']))
        <div class="my-12">
            <p class="type-h2 uppercase">{{ trans('people.coach_page.related_videos') }}:</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-16">
                @foreach($coach['videos'] as $video)
                    <div class="max-w-sm">
                        <p class="type-b4 mb-1">{{ $video['title'] }}</p>
                        <x-youtube-embed :video-id="$video['video_id']"></x-youtube-embed>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        @if(count($coach['events']))
        <div class="my-12">
            <p class="type-h2 uppercase">{{ trans('people.coach_page.related_events') }}</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-16">
                @foreach($coach['events'] as $event)
                    @include('front.events.event-card')
                @endforeach
            </div>
        </div>
        @endif
    </div>

@endsection
