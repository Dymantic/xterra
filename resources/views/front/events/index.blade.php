@extends('front.base')

@section('content')
    <div class="py-20 px-8">
        <p class="max-w-2xl mx-auto text-center type-h4">These are our upcoming events to look out for, both locally and
            internationally.</p>
        <div class="flex justify-center flex-wrap my-12">
            @foreach(['cycle','duathlon','lifestyle','run','seminar','swim','training','triathlon'] as $category)
                <div class="m-4 flex flex-col items-center">
                    @include('svg.event-categories.' . $category, ['classes' => 'h-8 text-red-700'])
                    <p class="type-b3 text-center capitalize">{{ $category }}</p>
                </div>
            @endforeach
        </div>

        <div class="max-w-3xl mx-auto bg-gray-100 shadow-small p-8">
            <p class="type-h1 uppercase border-b border-red-700">Upcoming Events</p>
            @foreach($events as $event)
                <div class="flex flex-col md:flex-row border-b border-grey-700 pb-3 mt-4">
                    <p class="px-2 md:hidden type-b2 w-64">{{ $event['dates'] }}</p>
                    <p class="px-2 hidden md:block type-h2 w-64">{{ $event['dates'] }}</p>
                    <p class="px-2 type-h2 flex-1">{{ $event['name'] }}</p>
                    <p class="px-2 md:hidden type-b2 w-48">{{ $event['location'] }}</p>
                    <p class="px-2 hidden md:block type-h2 w-48">{{ $event['location'] }}</p>
                </div>
            @endforeach
        </div>

    </div>

    <div class="flex flex-wrap justify-around max-w-5xl mx-auto px-4">
        @foreach($events as $event)
            <div class="my-8 max-w-md shadow-small flex flex-col justify-between">
                <img src="{{ $event['card_image']['web'] }}" alt="{{ $event['name'] }}">
                <div class="py-2 px-4 bg-gray-100 flex flex-col flex-1">
                    <div class="flex-1">
                        <div class="flex justify-between items-center p-2 border-b border-red-700">
                            <p class="type-h2 uppercase">{{ $event['name'] }}</p>
                            <div class="flex justify-end">
                                @foreach($event['categories'] as $category)
                                    @include('svg.event-categories.' . $category, ['classes' => 'h-4 md:h-8 ml-1 text-red-700'])
                                @endforeach
                            </div>
                        </div>
                        <div class="flex items-center">
                            @include('svg.icons.location', ['classes' => 'h-6 text-red-700 mr-2'])
                            <p class="type-h2">{{ $event['location'] }}</p>
                        </div>
                        <div class="flex items-center">
                            @include('svg.icons.calendar', ['classes' => 'h-6 text-red-700 mr-2'])
                            <p class="type-h2">{{ $event['dates'] }}</p>
                        </div>
                        <p class="type-b1 my-4">{{ $event['intro'] }}</p>
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ $event['full_slug'] }}" class="type-b2 uppercase hover:text-blue-700">View Event
                            &gt;</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@endsection
