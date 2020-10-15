<div class="py-20 px-8" id="fees">
    <div class="max-w-5xl mx-auto">
        <p class="type-h2 uppercase mb-6">Fees</p>
        <table class="w-full max-w-2xl mx-auto border border-red-700">
            <thead>
            <tr class="text-left border-b border-red-700">
                <th class="p-2">Category</th>
                <th class="p-2">Fee</th>
            </tr>
            </thead>
            <tbody>
            @foreach($activity['fees'] as $fee)
                <tr class="@if($loop->odd) bg-gray-200 @endif">
                    <td class="px-2 py-1">{{ $fee['category'] }}</td>
                    <td class="px-2 py-1">{{ $fee['fee'] }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="mt-12 max-w-2xl mx-auto admin-edited">
            <div>{!! $activity['fees_notes'] !!}</div>
        </div>
    </div>

</div>
