@if(count($data) > 0)
    @php $headings = array_shift($data) @endphp
<table class="w-full border border-red-700">
    <thead>
    <tr class="border-b border-red-700 text-white bg-red-700">
        @foreach($headings as $heading)
            <th class="p-2 text-left font-bold">{{ $heading }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody class="text-sm">
    @foreach($data as $row)
    <tr class="@if($loop->odd) bg-gray-200 @endif">
        @foreach($row as $cell)
        <td class="py-1 px-2">{{ $cell }}</td>
        @endforeach
    </tr>
    @endforeach
    </tbody>
</table>
@endif
