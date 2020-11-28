@extends('front.base')

@section('content')
    <div class="py-20 px-8">
        <p class="max-w-2xl mx-auto text-center type-h4">{{ trans('events.index_intro') }}</p>
        <div class="flex justify-center flex-wrap my-12">
            @foreach(['triathlon','duathlon','run', 'cycle','swim','training','seminar','lifestyle',] as $category)
                <div class="m-4 flex flex-col items-center">
                    @include('svg.event-categories.' . $category, ['classes' => 'h-8 text-red-700'])
                    <p class="type-b3 text-center capitalize">{{ trans("activities.{$category}") }}</p>
                </div>
            @endforeach
        </div>

        <div class="max-w-3xl mx-auto bg-gray-100 shadow-small p-8">
            <p class="type-h1 uppercase border-b border-red-700">{{ trans('events.upcoming_events') }}</p>
            @foreach($events as $event)
                <div class="flex flex-col md:flex-row border-b border-grey-700 pb-3 mt-4">
                    <p class="px-2 md:hidden type-b2 w-64">{{ $event['dates'] }}</p>
                    <p class="px-2 hidden md:block type-h2 w-48">{{ $event['dates'] }}</p>
                    <p class="px-2 type-h2 flex-1">
                        <a href="{{ $event['full_slug'] }}" class="hover:text-red-700">{{ $event['name'] }}</a>
                    </p>
                    <p class="px-2 md:hidden type-b2 w-64">{{ $event['location'] }}</p>
                    <p class="px-2 hidden md:block type-h2 w-64">{{ $event['location'] }}</p>
                </div>
            @endforeach
        </div>

    </div>

    <div class="flex flex-wrap justify-around max-w-5xl mx-auto px-4 pb-20">
        @foreach($events as $event)
            @include('front.events.event-card')
        @endforeach
    </div>

    @if($past_events->count())
    <div class="max-w-5xl mx-auto">
        <p class="type-h2 mb-6 uppercase max-w-4xl mx-auto">{{ trans('events.past_events') }}</p>
        <div class="flex flex-wrap justify-around px-4 pb-20">
            @foreach($past_events as $event)
                @include('front.events.event-card')
            @endforeach
        </div>
    </div>
    @endif

@endsection
