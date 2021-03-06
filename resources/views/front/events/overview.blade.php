<div class="py-20 px-8">
    <div class="max-w-2xl mx-auto admin-edited">{!! $event['overview'] !!}</div>

    <div class="max-w-xl mx-auto mt-12 p-6 rounded shadow-lg bg-gray-200 type-b1">
        <p class="type-h2 uppercase mb-6 border-b-2 border-red-700">{{ trans('events.overview') }}</p>
        <p>
            <span class="font-bold">{{ trans('events.name') }}: </span>
            <span>{{ $event['name'] }}</span>
        </p>
        <p>
            <span class="font-bold">{{ trans('events.dates') }}: </span>
            <span>{{ $event['dates'] }}</span>
        </p>
        <p>
            <span class="font-bold">{{ trans('events.location') }}: </span>
            <span>{{ $event['location'] }}</span>
        </p>
        <p>
            <span class="font-bold">{{ trans('events.venue') }}: </span>
            <span>{{ $event['venue_name'] }}</span>
        </p>
        <p>
            <span class="font-bold">{{ trans('events.address') }}: </span>
            <span>{{ $event['venue_address'] }}</span>
            @if($event['venue_maplink'])
                <a href="{{ $event['venue_maplink'] }}" class="font-bold text-blue-600 hover:underline">({{ trans('events.see_map') }})</a>
            @endif
        </p>
    </div>
</div>
