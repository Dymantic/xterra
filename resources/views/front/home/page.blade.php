@extends('front.base', ['all_scripts' => false, 'has_promo_video' => true, 'flickity' => true])

@section('title'){{ trans('homepage.meta.title') }}@endsection

@section('head')
    @include('front.partials.og-meta', [
        'ogTitle' => trans('homepage.meta.title'),
        'ogDescription' => trans('homepage.meta.description')
    ])
@endsection


@section('content')
    @include('front.home.banner')
    @include('front.home.cards')
    @include('front.home.initiative', ['campaign' => $page['campaign'] ?? null])
    @include('front.home.event', ['event' => $page['event'], 'card_header' => trans('homepage.next_event')])
    @include('front.home.promotion', ['promo' => $page['promotion']])
    @include('front.home.instagram', ['ig_posts' => $page['instagram']['posts']])
    @include('front.home.blog', ['posts' => $page['blog']['posts']])
@endsection
