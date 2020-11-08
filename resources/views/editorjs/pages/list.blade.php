@if($ordered)
    <ol class="list-decimal my-6 list-inside">
        @else
            <ul class="list-decimal list-inside my-6">
                @endif

                @foreach($items as $item)
                    <li>{!! $item !!}</li>
            @endforeach

            @if($ordered)
    </ol>
    @else
    </ul>
@endif
