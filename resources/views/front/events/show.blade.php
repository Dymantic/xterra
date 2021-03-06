@extends('front.base', ['all_scripts' => false, 'flickity' => true, 'has_promo_video' => true])

@section('title'){{ $event['name'] }}@endsection

@section('head')
    @include('front.partials.og-meta', [
        'ogTitle' => $event['name'],
        'ogDescription' => $event['intro'],
        'ogImage' => url($event['banner_image']['banner']),
    ])
    <link rel="canonical" href="{{ $event['canonical_slug'] }}">
    <style>
        .event-banner {
            background-image: url({{ $event['banner_image']['banner']}});
        }

        @media screen and (max-width: 639px) {
            .event-banner {
                background-image: none;
            }
        }
    </style>
@endsection

@section('content')
    @include('front.events.banner')
    @include('front.events.event-nav')
    @include('front.events.overview')
    @include('front.events.races-activities')
    @include('front.events.schedule')
    @include('front.events.fees')
    @include('front.events.travel')
    @include('front.events.accommodation')
    @include('front.events.sponsors')
    @include('front.events.galleries')
    @include('front.events.videos')
@endsection
