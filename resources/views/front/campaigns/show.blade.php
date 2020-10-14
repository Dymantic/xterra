@extends('front.base')

@section('content')
    @include('front.campaigns.banner')
    @include('front.campaigns.narrative')
    @include('front.campaigns.promotion', ['promo' => $campaign['promotion']])
    @include('front.home.event', ['event' => $campaign['event']])
    <div class="py-20 px-6">
        <div class="max-w-5xl mx-auto">
            <p class="type-h2 uppercase mb-6">Related Blog Post</p>
            <div class="grid gap-10 md:grid-cols-3 place-content-center">
                @foreach($campaign['articles'] as $post)
                @include('front.blog.post-index-card')
                @endforeach
            </div>
        </div>
    </div>

@endsection
