@extends('front.base')

@section('content')
    @include('front.home.banner')
    @include('front.home.cards')
    @include('front.home.initiative', ['campaign' => $page['campaign'] ?? null])
    @include('front.home.event', ['event' => $page['event']])
    @include('front.home.promotion', ['promo' => $page['promotion']])
    @include('front.home.instagram', ['ig_posts' => $page['instagram']['posts']])
    @include('front.home.blog', ['posts' => $page['blog']['posts']])

@endsection
