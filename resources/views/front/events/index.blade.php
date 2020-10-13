@extends('front.base')

@section('content')
    @foreach($events as $event)
        <div class="my-8">
            <a href="/top-secret/events/{{ $event['slug'] }}">{{ $event['name']['en'] }}</a>
        </div>
    @endforeach
@endsection
