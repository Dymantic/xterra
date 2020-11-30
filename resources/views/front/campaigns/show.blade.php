@extends('front.base', ['all_scripts' => false, 'has_promo_video' => true, 'flickity' => true])

@section('title'){{ $campaign['title'] }}@endsection

@section('head')
    @include('front.partials.og-meta', [
        'ogTitle' => $campaign['title'],
        'ogDescription' => $campaign['description'],
        'ogImage' => url($campaign['banner_image']['full']),
    ])
    <link rel="canonical" href="{{ $campaign['canonical_slug'] }}">
@endsection

@section('content')
    @include('front.campaigns.banner')
    @include('front.campaigns.narrative')
    @include('front.campaigns.promotion', ['promo' => $campaign['promotion']])
    @include('front.home.event', ['event' => $campaign['event'], 'card_header' => trans('campaigns.related_event')])
    <div class="py-20 px-6">
        <div class="max-w-5xl mx-auto">
            <p class="type-h2 uppercase mb-6">{{ trans('campaigns.blog_heading') }}</p>
            <div class="grid gap-10 md:grid-cols-3 place-content-center">
                @foreach($campaign['articles'] as $post)
                @include('front.blog.post-index-card')
                @endforeach
            </div>
        </div>
    </div>

    @auth
    @include('front.campaigns.people', ['people' => $campaign['people']])
    @endauth

    <div class="text-center pb-20">
        <a class="type-b2 hover:text-red-700" href="{{ localUrl('/initiatives') }}">{{ trans('campaigns.all_initiatives') }} &gt;</a>
    </div>

@endsection
