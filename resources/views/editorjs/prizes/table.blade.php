@if(count($data) > 0)
<table class="w-full border border-gray-300">
    <thead>
    <tr class="border-b border-gray-300">
        @foreach($data[0] as $heading)
            <th class="p-2 text-left font-bold">{{ $heading }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @php array_shift($data) @endphp
    @foreach($data as $row)
    <tr class="@if($loop->even) bg-blue-100 @endif">
        @foreach($row as $cell)
        <td class="py-1 px-2">{{ $cell }}</td>
        @endforeach
    </tr>
    @endforeach
    </tbody>
</table>
@endif
