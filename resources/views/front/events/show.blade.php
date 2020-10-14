@extends('front.base')

@section('content')
    @include('front.events.banner')
    @include('front.events.event-nav')
    @include('front.events.overview')
    @include('front.events.races-activities')
    @include('front.events.schedule')
    @include('front.events.fees')

    <div class="py-20 px-8">
        <div class="max-w-5xl mx-auto">
            <p class="type-h2 uppercase mb-6">Travel</p>
            @foreach($event['travel_routes'] as $travel_route)
            <div class="max-w-xl mx-auto mb-12">
                <p class="font-bold mb-4">{{ $travel_route['name'] }}</p>
                <p>{{ $travel_route['description'] }}</p>
                @if($travel_route['image'])
                <img class="mt-4" src="{{ $travel_route['image'] }}" alt="{{ $travel_route['name'] }}">
                @endif
            </div>
            @endforeach
        </div>
    </div>

    <div class="py-20 px-8">
        <div class="max-w-5xl mx-auto">
            <p class="type-h2 uppercase mb-6">Accommodation</p>
            @foreach($event['accommodation'] as $hotel)
                <div class="max-w-xl mx-auto mb-12">
                    <p class="font-bold mb-4">{{ $hotel['name'] }}</p>
                    @if($hotel['phone'])
                    <div class="flex items-center">
                        @include('svg.icons.phone', ['classes' => 'text-gray-600 h-4 mr-3'])
                        <p>{{ $hotel['phone'] }}</p>
                    </div>
                    @endif

                    @if($hotel['email'])
                        <div class="flex items-center">
                            @include('svg.icons.mail', ['classes' => 'text-gray-600 h-4 mr-3'])
                            <p>{{ $hotel['email'] }}</p>
                        </div>
                    @endif

                    @if($hotel['link'])
                        <div class="flex items-center">
                            @include('svg.icons.link', ['classes' => 'text-gray-600 h-4 mr-3'])
                            <a href="{{ $hotel['link'] }}">{{ $hotel['link'] }}</a>
                        </div>
                    @endif

                    <p class="mt-4">{{ $hotel['description'] }}</p>
                </div>
            @endforeach
        </div>
    </div>



@endsection
