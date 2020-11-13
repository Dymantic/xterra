@extends('front.base', ['flickity' => true, 'all_scripts' => false, 'has_promo_video' => true])

@section('title'){{ $activity['name'] }}@endsection

@section('head')
    @include('front.partials.og-meta', [
        'ogTitle' => $activity['name'],
        'ogDescription' => $activity['intro'],
        'ogImage' => url($activity['title_image']['banner']),
    ])
    <link rel="canonical" href="{{ $activity['canonical_slug'] }}">
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
