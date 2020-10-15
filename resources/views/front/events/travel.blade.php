<div class="py-20 px-8" id="travel">
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

        @if($event['travel_guide'])
        <div class="mt-12 text-center">
            <a download="travel_guide" href="{{ $event['travel_guide'] }}" class="type-h4 uppercase">Download Travel Guide</a>
        </div>
        @endif
    </div>
</div>
