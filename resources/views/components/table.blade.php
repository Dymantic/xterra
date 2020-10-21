<table class="w-full border border-red-700">
    @if($hasHeadings())
    <thead>
    <tr class="text-left border-b border-red-700 text-white bg-red-700">
        @foreach($headings as $heading)
            <th class="p-2">{{ $heading }}</th>
        @endforeach
    </tr>
    </thead>
    @endif
    <tbody class="text-sm">
    @foreach($rows as $row)
        <tr class="@if($loop->odd) bg-gray-200 @endif">
            @if($hasColumns())
            @foreach($columns as $column)
                <td class="px-2 py-1">{{ $row[$column] }}</td>
            @endforeach
            @else
            @foreach($row as $entry)
                <td class="px-2 py-1">{{ $entry }}</td>
            @endforeach
            @endif
        </tr>
    @endforeach
    </tbody>
</table>
