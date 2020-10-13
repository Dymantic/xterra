@extends('front.base')

@section('content')
    @foreach($campaigns as $campaign)
    <div class="my-8">
        <a href="/top-secret/campaigns/{{ $campaign['slug'] }}">{{ $campaign['title']->in('en') }}</a>
    </div>
    @endforeach
@endsection
