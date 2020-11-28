<div class="my-8 max-w-md shadow-small flex flex-col justify-between">
    <a href="{{ localUrl($event['full_slug']) }}">
        <img src="{{ $event['card_image']['web'] }}" alt="{{ $event['name'] }}">
    </a>
    <div class="py-2 px-4 bg-gray-100 flex flex-col flex-1">
        <div class="flex-1">
            <div class="flex justify-between items-center p-2 border-b border-red-700">
                <a href="{{ localUrl($event['full_slug']) }}" class="hover:text-red-700">
                    <p class="type-h2 uppercase">{{ $event['name'] }}</p>
                </a>
                <div class="flex justify-end divide-x divide-gray-300">
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
            <a href="{{ $event['full_slug'] }}" class="type-b2 uppercase hover:text-blue-700">{{ trans('events.see_event') }} &gt;</a>
        </div>
    </div>
</div>
