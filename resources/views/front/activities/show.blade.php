@extends('front.base', ['flickity' => true, 'all_scripts' => false, 'has_promo_video' => true])

@section('head')
    <style>
        .event-banner {
            background-image: url({{ $activity['title_image']['banner']}});
        }

        @media screen and (max-width: 639px) {
            .event-banner {
                background-image: none;
            }
        }
    </style>
@endsection

@section('content')
    @include('front.activities.banner')
    @include('front.activities.activity-nav')
    @include('front.activities.overview')
    @include('front.activities.courses')
    @include('front.activities.schedule')
    @include('front.activities.prizes')
    @include('front.activities.fees')
    @include('front.activities.rules')
@endsection
