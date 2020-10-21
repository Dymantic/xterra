<table class="w-full border border-red-700">
    <tbody>
    @foreach($data as $row)
    <tr class="@if($loop->even) bg-gray-100 @endif">
        @foreach($row as $cell)
        <td class="px-2 py-1">{!! $cell !!}</td>
        @endforeach
    </tr>
    @endforeach
    </tbody>
</table>
