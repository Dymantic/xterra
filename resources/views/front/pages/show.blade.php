@extends('front.base', ['all_scripts' => false])

@section('title'){{ 'XTERRA Taiwan | ' . $page['title'] }}@endsection

@section('head')
    @include('front.partials.og-meta', [
        'ogTitle' => 'XTERRA Taiwan | ' . $page['title'],
        'ogDescription' => $page['description']
    ])
@endsection

@section('content')
    <div class="max-w-4xl mx-auto px-6 py-20">
        <h1 class="type-h0 text-center">{{ $page['title'] }}</h1>

        <div class="mt-20">{!! $page['content'] !!}</div>
    </div>

@endsection
