@if($activity['has_schedule'])
<div class="pb-20 px-8" id="schedule">
    <div class="max-w-4xl mx-auto">
        <p class="type-h2 uppercase mb-6">{{ trans('activities.schedule') }}</p>
        @foreach($activity['schedule'] as $day)
            <div class="max-w-3xl mx-auto mb-12">
                <p class="type-h2 uppercase">{{ $day['date'] }} <span class="ml-4 text-gray-600">({{ $day['day_of_week'] }})</span></p>
                <x-table :headings="[trans('events.schedule_time'), trans('events.schedule_activity'), trans('events.schedule_location')]" :rows="$day['entries']" :columns="['time_of_day', 'item', 'location']"></x-table>
            </div>
        @endforeach

        <div class="mt-12 max-w-2xl mx-auto admin-edited">
            <div>{!! $activity['schedule_notes'] !!}</div>
        </div>
    </div>
</div>
@endif
