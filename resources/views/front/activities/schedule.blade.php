<div class="py-20 px-8">
    <div class="max-w-5xl mx-auto">
        <p class="type-h2 uppercase mb-6">Schedule</p>
        @foreach($activity['schedule'] as $day)
            <div class="max-w-2xl mx-auto mb-12">
                <p class="type-h2 uppercase">{{ $day['date'] }} <span class="ml-4 text-gray-600">({{ $day['day_of_week'] }})</span></p>
                <table class="w-full border border-red-700">
                    <thead>
                    <tr class="text-left border-b border-red-700">
                        <th class="p-2">Time</th>
                        <th class="p-2">Activity</th>
                        <th class="p-2">Location</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($day['entries'] as $entry)
                        <tr class="@if($loop->odd) bg-gray-200 @endif">
                            <td class="px-2 py-1">{{ $entry['time_of_day'] }}</td>
                            <td class="px-2 py-1">{{ $entry['item'] }}</td>
                            <td class="px-2 py-1">{{ $entry['location'] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach

        <div class="mt-12 max-w-2xl mx-auto admin-edited">
            <div>{!! $activity['schedule_notes'] !!}</div>
        </div>
    </div>
</div>
