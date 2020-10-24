@if($event['has_accommodation'])
<div class="pb-20 px-8" id="accommodation">
    <div class="max-w-4xl mx-auto">
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
@endif
