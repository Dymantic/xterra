<div class="max-w-2xl mx-auto p-6 rounded shadow-small mb-12">
    <p class="uppercase type-h2 text-blue-700">
        <a class="hover:text-blue-500" href="/top-secret/activities/{{ $activity['slug'] }}">
            {{ $activity['name'] }}
        </a>
    </p>
    @if($activity['distance'])
        <p><span class="font-bold">{{ trans('events.distance') }}: </span>{{ $activity['distance'] }}</p>
    @endif
    <p class=""><span class="font-bold">{{ trans('events.date') }}: </span>{{ $activity['date'] }}</p>
    <p class="max-w-xl"><span class="font-bold">{{ trans('events.intro') }}: </span>{{ $activity['intro'] }}</p>
    <div class="text-right mt-4">
        <a class="type-b2 text-blue-700 hover:text-blue-500 uppercase" href="/top-secret/activities/{{ $activity['slug'] }}">{{ $type === 'race' ? trans('events.view_race') : trans('events.view_activity') }} &gt;</a>
    </div>
</div>
