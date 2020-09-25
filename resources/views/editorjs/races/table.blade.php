<table class="w-full border border-gray-300">
    <tbody>
    @foreach($data as $row)
    <tr class="@if($loop->even) bg-blue-100 @endif">
        @foreach($row as $cell)
        <td class="p-1">{{ $cell }}</td>
        @endforeach
    </tr>
    @endforeach
    </tbody>
</table>
