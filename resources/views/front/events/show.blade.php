@extends('front.base', ['all_scripts' => false, 'flickity' => true, 'has_promo_video' => true])

@section('content')
    @include('front.events.banner')
    @include('front.events.event-nav')
    @include('front.events.overview')
    @include('front.events.races-activities')
    @include('front.events.schedule')
    @include('front.events.fees')
    @include('front.events.travel')
    @include('front.events.accommodation')
    @include('front.events.galleries')
    @include('front.events.videos')
@endsection
